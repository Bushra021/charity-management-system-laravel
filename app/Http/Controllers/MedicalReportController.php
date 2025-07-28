<?php
namespace App\Http\Controllers;

use App\Models\DisabilityCause;
use App\Models\DisabilityType;
use App\Models\Patient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalReport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use Omaralalwi\Gpdf\Gpdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;




// هذا هو الـ alias الصحيح لمكتبة Meneses\LaravelMpdf



class MedicalReportController extends Controller
{
    public function create()
    {
        $patient = Auth::user()->patient;
        $reports = $patient->medicalReports()->latest()->get();

        return view('medical_report.report', compact('reports'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'report_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:20048',
            'title' => 'nullable|string|max:255',
        ]);

        $path = $request->file('report_file')->store('medical_reports','public');

        MedicalReport::create([
            'patient_id' => Auth::user()->patient->id, // ربط التقرير بالمريض المسجل دخول
            'title' => $request->title ?? 'تقرير طبي مرفوع',
            'file_path' => $path,
            'is_generated' => false,
        ]);

        return redirect()->route('patient.reports.create')->with('success', 'تم رفع التقرير بنجاح');
    }

    public function destroy(MedicalReport $report)
    {
        // تحقق أن التقرير يعود للمريض المسجل دخولًا
        if ($report->patient_id !== Auth::user()->patient->id) {
            abort(403, 'غير مصرح لك بحذف هذا التقرير');
        }

        // احذف الملف من التخزين
        if ($report->file_path && Storage::disk('public')->exists($report->file_path)) {
            Storage::disk('public')->delete($report->file_path);
        }

        // احذف التقرير من قاعدة البيانات
        $report->delete();

        return redirect()->route('patient.reports.create')->with('success', 'تم حذف التقرير بنجاح.');
    }




    public function generate($id)
    {

        $patient = Patient::with([

            'providedServices.service' => function ($q) {
                $q->select('id', 'name'); // جدول tools فيه id وname
            },
            'providedServices' => function ($q) {
                $q->select('id', 'patient_id', 'service_id', 'received', 'needed','status','start_date','end_date');
            },
            'notes' => function ($q) {
                $q->select('id', 'patient_id', 'name', 'date','user_id');
            },
            'appointments.service' => function ($q) {
                $q->select('id', 'name'); // جدول tools فيه id وname
            },
            'appointments' => function ($q) {
                $q->select('id', 'patient_id', 'service_id', 'date','status')
                    ->with(['service:id,name']); // تحميل اسم الخدمة
            },
        ])->findOrFail($id);
        $disability_type = $patient->disabilityType;
        $disability_cause = $patient->disabilityCause;


        // تحضير الـ HTML - استبدلها بالـ view الحقيقي لو حبيت
        $html = view('medical_report.report_pdf', compact('patient','disability_cause','disability_type'))->render();

        $filename = 'medical_report_' . time() . '.pdf';
        $storagePath = 'medical_reports/' . $filename; // مسار التخزين داخل disk public

        // توليد محتوى PDF كـ string
        $content = app(Gpdf::class)->generate($html);

        // تخزين الملف داخل storage/app/public/medical_reports/
        Storage::disk('public')->put($storagePath, $content);

        // تسجيل التقرير في قاعدة البيانات
        MedicalReport::create([
            'patient_id' => $patient->id,
            'title' => 'تقرير طبي منشأ تلقائيًا',
            'file_path' => $storagePath,
            'is_generated' => true,
        ]);

        return redirect()->back()
            ->with('success', 'تم إنشاء التقرير الطبي وحفظه بنجاح.');
    }

    public function destroy2($id)
    {
        // جلب التقرير أو إرجاع خطأ 404 إذا غير موجود
        $report = MedicalReport::findOrFail($id);

        // حذف الملف من التخزين إذا كان موجودًا
        if ($report->file_path && Storage::disk('public')->exists($report->file_path)) {
            Storage::disk('public')->delete($report->file_path);
        }

        // حذف السجل من قاعدة البيانات
        $report->delete();

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->back()->with('success', 'تم حذف التقرير الطبي بنجاح.');
    }





//    public function generate()
//    {
//        $patient = Auth::user()->patient;
//        $html = view('medical_report.report_pdf', compact('patient'))->render();
//
//        // إنشاء PDF كنص (binary string)
//        $pdfContent = app(Gpdf::class)->generate($html);
//
//        // أو لتحفظ الملف مباشرة على القرص:
//        $file = app(Gpdf::class)->generateWithStore(
//            $html,
//            public_path('medical_reports/'),
//            'medical_report_' . time(),
//            true,    // stream بعد التخزين
//            false    // تعطيل SSL verify في البيئة المحلية
//        );
//        // $file يحتوي على مسار الملف واسم `ObjectURL`
//
//        // مثال لحفظ مسار الملف في قاعدة البيانات:
//        MedicalReport::create([
//            'patient_id' => $patient->id,
//            'title'      => 'تقرير طبي منشأ تلقائيًا',
//            'file_path'  => 'medical_reports/' . ($file['ObjectURL'] ?? 'نص'),
//            'is_generated' => true,
//        ]);
//
//        return redirect()->route('patient.reports.create')
//            ->with('success', 'تم إنشاء التقرير الطبي بنجاح');
//    }







//    use Mpdf\Mpdf;
//
//    public function generate()
//    {
//        $patient = Auth::user()->patient;
//        $html = view('medical report.report_pdf', compact('patient'))->render();
//
//        // جلب إعدادات mPDF من ملف الكونفيج
//        $mpdfConfig = config('pdf');
//
//        // إنشاء كائن mPDF مع الإعدادات المحملة
//        $mpdf = new Mpdf($mpdfConfig);
//
//        $mpdf->WriteHTML($html);
//
//        $filename = 'medical report' . time() . '.pdf';
//        $path = 'medical_reports/' . $filename;
//
//        Storage::disk('public')->put($path, $mpdf->Output($filename, \Mpdf\Output\Destination::STRING_RETURN));
//
//        MedicalReport::create([
//            'patient_id' => $patient->id,
//            'title' => 'تقرير طبي منشأ تلقائيًا',
//            'file_path' => $path,
//            'is_generated' => true,
//        ]);
//
//        return redirect()->route('patient.reports.create')->with('success', 'تم إنشاء التقرير الطبي بنجاح');
//    }
//

}

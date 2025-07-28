<?php

namespace App\Http\Controllers;
use App\Models\Patient;
use App\Models\Attachment;
use App\Models\Grade;
use App\Models\Effect;
use App\Models\ProvidedService;
use App\Models\Note;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{

    public function store(Request $request, $patientId)
    {
        $request->validate([
            'name' => 'required|string|max:1000',
            'date' => 'required|date|before_or_equal:today',
        ], [
            'name.required' => 'نص الملاحظة مطلوب.',
            'name.string' => 'نص الملاحظة يجب أن يكون نصاً.',
            'name.max' => 'نص الملاحظة يجب ألا يتجاوز 1000 حرف.',
            'date.required' => 'تاريخ الملاحظة مطلوب.',
            'date.date' => 'تاريخ الملاحظة غير صالح.',
            'date.before_or_equal' => 'تاريخ الملاحظة يجب أن يكون اليوم أو قبله.',
        ]);

        Note::create([
            'name' => $request->name,
            'date' => $request->date,
            'user_id' => auth()->id(),
            'patient_id' => $patientId,
        ]);


        return redirect()->back()->with('success', 'تمت إضافة الملاحظة بنجاح!');
    }

    // تعديل ملاحظة موجودة
    public function update(Request $request, $patientId, $noteId)
    {
        $request->validate([
            'name' => 'required|string|max:1000',
            'date' => 'required|date|before_or_equal:today',
        ],[
            'name.required' => 'نص الملاحظة مطلوب.',
            'name.string' => 'نص الملاحظة يجب أن يكون نصاً.',
            'name.max' => 'نص الملاحظة يجب ألا يتجاوز 1000 حرف.',
            'date.required' => 'تاريخ الملاحظة مطلوب.',
            'date.date' => 'تاريخ الملاحظة غير صالح.',
            'date.before_or_equal' => 'تاريخ الملاحظة يجب أن يكون اليوم أو قبله.',
        ]);

        $note = Note::findOrFail($noteId);
        if ($note->user_id !== auth()->id()) {
            abort(403, 'غير مصرح لك بتعديل هذه الملاحظة.');
        }

        $note->update([
            'name' => $request->name,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'تم تعديل الملاحظة بنجاح!');
    }

    // حذف ملاحظة
    public function destroy($note)
    {
        $note = Note::findOrFail($note);
        if ($note->user_id !== auth()->id()) {
            abort(403, 'غير مصرح لك بتعديل هذه الملاحظة.');
        }
        $note->delete();

        return redirect()->back()->with('success', 'تم حذف الملاحظة بنجاح!');
    }



    public function searchPatients(Request $request)
    {
        $search = $request->input('query');

        // نجيب قائمة معرفات المرضى الموجودين في جدول الخدمات
       // $servicesPatientIds = DB::table('provided_services')->pluck('patient_id')->toArray();

        // نجيب قائمة معرفات المرضى الموجودين في جدول تأثير الإعاقة
        $disabilityPatientIds = DB::table('effects')->pluck('patient_id')->toArray();

        // نعمل تقاطع بين القائمتين
      //  $intersectedIds = array_intersect($servicesPatientIds, $disabilityPatientIds);

        // نجيب فقط المرضى الموجودين في التقاطع، واللي الاسم أو الهوية تطابق البحث
        $patients = DB::table('patients')
            ->whereIn('id', $disabilityPatientIds)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('national_id', 'like', "%{$search}%");
            })
            ->get();
        return view('employee.note', compact('patients'));

    }



    public function showPatient($id)
    {
        $patient = Patient::with([
            'attachments.tool' => function ($q) {
               $q->select('id', 'name'); // جدول tools فيه id وname
           },
            'attachments' => function ($q) {
                $q->select('id', 'patient_id','tool_id','received', 'needed');
            },
            'effect.healthPhysicalGrade:id,name',
            'effect.healthMentalGrade:id,name',
            'effect.healthPsychologicalGrade:id,name',
            'effect.educationGrade:id,name',
            'effect.maritalLifeGrade:id,name',
            'effect.socialActivitiesGrade:id,name',
            'effect.socialSkillsGrade:id,name',
            'effect.selfManagementGrade:id,name',
            'effect.familyRelationshipGrade:id,name',
            'effect.workGrade:id,name',
            'effect.financialIndependenceGrade:id,name',
            'effect.publicLifeGrade:id,name',

            'effect' => function ($q) {
                $q->select('id', 'health_physical','patient_id' ,'health_mental', 'health_psychological', 'education', 'marital_life', 'social_activities', 'social_skills',
        'self_management', 'family_relationship', 'work', 'financial_independence', 'public_life');
            },
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

            // تحميل نوع الإعاقة
            'disabilityType' => function ($q) {
                $q->select('id', 'name');
            },

            // تحميل سبب الإعاقة
            'disabilityCause' => function ($q) {
                $q->select('id', 'name');
            },
            'medicalReports' => function ($q) {
                $q->select('id', 'title','content','file_path','is_generated','created_at','patient_id');
            },

        ])
            ->select('id', 'name', 'national_id','self_dependence_level','birth_date', 'social_status','disability_type_id',
                'disability_cause_id','phone_number', 'fax_number', 'self_dependence_level', 'injury_date', 'toilet_facilities', 'disability_type_id',
                'disability_cause_id')->findOrFail($id);

        // أثناء الفحص أرجع البيانات على شكل JSON


        // بعد انتهاء الفحص واستقرار الكود، استبدله بـ:
         return view('employee.note_info', compact('patient'));
    }

}





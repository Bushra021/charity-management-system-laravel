<?php

namespace App\Http\Controllers;
use App\Models\Attachment;
use App\Models\Patient;
use App\Models\ProvidedService;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\AvailableAppointment;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;

class AppointmentController extends Controller
{
    // عرض المواعيد المتاحة
    public function showAvailableAppointments()
    {
        $patient = Patient::where('user_id', auth()->id())->first();

        // جلب الخدمات المقدمة للمريض
        $provided = ProvidedService::where('patient_id', $patient->id)
            ->whereIn('status', ['scheduled','pending'])
            ->join('services', 'provided_services.service_id', '=', 'services.id')
            ->select('provided_services.service_id', 'services.name')
            ->get();
        // استخراج جميع service_id
        $serviceIds = $provided->pluck('service_id');

        // جلب المواعيد المتاحة للخدمات المقدمة
        $appointments = AvailableAppointment::where('is_booked', false)
            ->whereDate('date', '>=', now()->toDateString())
            ->whereIn('service_id', $serviceIds)
            ->with('service')
            ->get();
          //  return$appointments;
        $appIds = Appointment::where('patient_id',$patient->id)->pluck('available_appointments_id');

    // ثانياً: جلب المواعيد المتاحة بناءً على هذه المعرفات
        $appointmentava = AvailableAppointment::whereIn('id', $appIds)->get();
        $app = Appointment::where('patient_id', '=', $patient->id)->get();

        return view('appointment.available', compact('appointments','provided'), compact('appointmentava','app'));
    }

// حجز موعد
    public function bookAppointment($id)
    {
        $patient = Patient::where('user_id', auth()->id())->first();

        $appointment = AvailableAppointment::findOrFail($id);

        if ($appointment->is_booked) {
            return redirect()->route('appointments.available')
                ->with('error', 'هذا الموعد تم حجزه بالفعل.');
        }

        // تحقق من وجود حجز آخر بنفس التاريخ والوقت (بغض النظر عن الخدمة)
        $existingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('date', $appointment->date)
            ->get();

        foreach ($existingAppointments as $existingAppointment) {
            $availableOld = AvailableAppointment::where('service_id', $existingAppointment->service_id)
                ->where('date', $existingAppointment->date)
                ->first();

            if ($availableOld) {
                if (
                    $availableOld->start_time < $appointment->end_time &&
                    $availableOld->end_time > $appointment->start_time
                ) {
                    return redirect()->route('appointments.available')
                        ->with('error', 'لديك حجز آخر يتعارض مع هذا الموعد.');
                }
            }
        }

        // إذا لا يوجد تداخل، احجز
        $appointment->update(['is_booked' => true]);

        Appointment::create([
            'patient_id' => $patient->id,
            'service_id' => $appointment->service_id,
            'date' => $appointment->date,
            'status' => 'pending',
            'available_appointments_id' => $appointment->id,
        ]);


        return redirect()->route('appointments.available')
            ->with('success', 'تم حجز الموعد بنجاح.');
    }




// إلغاء حجز
    public function destroy($id)
    {
        $patient = Patient::where('user_id', auth()->id())->first();

        $appointment = Appointment::findOrFail($id);

        // تأكد أن المريض الحالي هو صاحب الحجز
        if ($appointment->patient_id != $patient->id) {
            return redirect()->back()->with('error', 'لا يمكنك إلغاء حجز ليس لك.');
        }

        // احفظ بيانات الموعد المتاح المرتبط
        $availableAppointment = AvailableAppointment::where('service_id', $appointment->service_id)
            ->where('date', $appointment->date)
            ->first();

        // احذف الحجز من جدول appointments
        $appointment->delete();

        // حدث الموعد المتاح ليصبح غير محجوز
        if ($availableAppointment) {
            $availableAppointment->update([
                'is_booked' => false,
            ]);
        }

        return redirect()->route('appointments.available')->with('success', 'تم إلغاء الحجز بنجاح.');
    }



}

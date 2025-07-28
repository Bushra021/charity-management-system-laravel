<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AvailableAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AvailableAppointmentController extends Controller
{
    // عرض مواعيد الموظف
    public function index()
    {

        $appointments = AvailableAppointment::where('user_id', Auth::id())->get();
        return view('appointment.appointment', compact('appointments'));
    }

    // عرض فورم إضافة موعد
    public function create()
    {
        $services = Auth::user()->services;  // يجيب الخدمات المرتبطة بالموظف الحالي
        return view('appointment.create', compact('services'));
    }

    // حفظ الموعد الجديد
    public function store(Request $request)
    {

        // قبل التحقق
        $request->merge([
            'start_time' => strlen($request->start_time) == 5 ? $request->start_time . ':00' : $request->start_time,
            'end_time' => strlen($request->end_time) == 5 ? $request->end_time . ':00' : $request->end_time,
        ]);

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',

        ], [
            'service_id.required' => 'يرجى اختيار خدمة.',
            'service_id.exists' => 'الخدمة المختارة غير موجودة.',

            'date.required' => 'يرجى اختيار تاريخ الموعد.',
            'date.date' => 'يرجى إدخال تاريخ صحيح.',
            'date.after_or_equal' => 'لا يمكنك اختيار تاريخ قبل اليوم.',

            'start_time.required' => 'يرجى إدخال وقت بداية الموعد.',
            'start_time.date_format' => 'صيغة وقت البداية غير صحيحة.',

            'end_time.required' => 'يرجى إدخال وقت نهاية الموعد.',
            'end_time.date_format' => 'صيغة وقت النهاية غير صحيحة.',
            'end_time.after' => 'يجب أن يكون وقت النهاية بعد وقت البداية.',
        ]);


        AvailableAppointment::create([
            'user_id' => Auth::id(),
            'service_id' => $request->service_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_booked' => false,
        ]);

        return redirect()->route('appointment.index')->with('success', 'تم إضافة الموعد بنجاح');
    }

    public function destroy($id)
    {
        $availableAppointment = AvailableAppointment::findOrFail($id);
        $availableAppointment->delete(); // هيك بحذف الموعد والمواعيد المرتبطة فيه أوتوماتيك
        return redirect()->back()->with('success', 'تم حذف الموعد وكل الحجوزات المرتبطة به.');
    }


    public function update(Request $request, $id)
    {

        // قبل التحقق
        $request->merge([
            'start_time' => strlen($request->start_time) == 5 ? $request->start_time . ':00' : $request->start_time,
            'end_time' => strlen($request->end_time) == 5 ? $request->end_time . ':00' : $request->end_time,
        ]);

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',

        ], [
            'service_id.required' => 'يرجى اختيار خدمة.',
            'service_id.exists' => 'الخدمة المختارة غير موجودة.',

            'date.required' => 'يرجى اختيار تاريخ الموعد.',
            'date.date' => 'يرجى إدخال تاريخ صحيح.',
            'date.after_or_equal' => 'لا يمكنك اختيار تاريخ قبل اليوم.',

            'start_time.required' => 'يرجى إدخال وقت بداية الموعد.',
            'start_time.date_format' => 'صيغة وقت البداية غير صحيحة.',

            'end_time.required' => 'يرجى إدخال وقت نهاية الموعد.',
            'end_time.date_format' => 'صيغة وقت النهاية غير صحيحة.',
            'end_time.after' => 'يجب أن يكون وقت النهاية بعد وقت البداية.',
        ]);


        $appointment = AvailableAppointment::findOrFail($id);

        $appointment->update([
            'service_id' => $request->service_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('appointment.index')->with('success', 'تم تعديل الموعد بنجاح');
    }

    public function edit($id)
    {
        $appointment = AvailableAppointment::findOrFail($id);
        $services = Auth::user()->services;

        return view('appointment.edit', compact('appointment', 'services'));
    }


}

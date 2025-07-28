<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\ProvidedService;
use App\Models\Service;

use Illuminate\Http\Request;


class ProvidedServiceController extends Controller
{

    public function create()
    {    $patient = Patient::where('user_id', auth()->id())->firstOrFail();

        $provided = ProvidedService::where('patient_id', $patient->id)
            ->where('needed', 1)
            ->where('status', 'pending')
            ->join('services', 'provided_services.service_id', '=', 'services.id')
            ->where('services.is_active', true)
            ->select(
                'provided_services.id as id',
                'provided_services.patient_id',
                'provided_services.service_id',
                'provided_services.needed',
                'provided_services.received',
                'services.name'
            )
            ->get();

        // 1. جمع معرّفات الخدمات التي حالتها "pending" أو "scheduled" لهذا المريض
        $blockedServiceIds = ProvidedService::where('patient_id', $patient->id)
            ->whereIn('status', ['pending', 'scheduled'])
            ->pluck('service_id');

        // 2. جلب الخدمات المتاحة للمريض: إما لم يطلبها سابقًا، أو أتمها "completed"
        $servicereqsted = Service::whereNotIn('id', $blockedServiceIds)
            ->where('is_active', true)->get();




        $provideddone = ProvidedService::where('patient_id', $patient->id)
            ->where('needed', 1)
            ->whereIn('status', ['scheduled', 'completed'])
            ->join('services', 'provided_services.service_id', '=', 'services.id')
            ->select(
                'provided_services.id as id',
                'provided_services.patient_id',
                'provided_services.service_id',
                'provided_services.needed',
                'provided_services.received',
                'provided_services.end_date',
                'provided_services.start_date',
                'provided_services.status',
                'services.name'

            )
            ->get();


        return view('provided service.service',compact( 'patient', 'provideddone','servicereqsted','provided'));
    }

    public function store(Request $request)
    {

        // تحقق من صحة البيانات
        $request->validate([
            'services' => 'required|array',
            'services.*.received' => 'nullable|boolean',
            'services.*.needed' => 'nullable|boolean',

        ]);



        $patientId = Patient::where('user_id', auth()->id())->value('id');

        foreach ($request->services as $serviceId => $data) {
            $received = !empty($data['received']) ? 1 : 0;
            $needed = !empty($data['needed']) ? 1 : 0;

            ProvidedService::create([
               // أو حسب معرف المريض إذا مختلف
                'patient_id' => $patientId,
                'service_id' => $serviceId,
                'received' => $received,
                'needed' => $needed,
            ]);

        }

        return redirect()->route('provided services.create')->with('success', 'تم تسجيل الخدمات بنجاح!');
    }
    public function destroy($id)
    {
        $provided = ProvidedService::findOrFail($id);
        $provided->delete();

        return redirect()->back()->with('success', 'تم حذف طلب الخدمة بنجاح.');

    }

}







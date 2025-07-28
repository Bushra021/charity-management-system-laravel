<?php

namespace App\Http\Controllers;

use App\Models\ProvidedService;
use App\Models\Service;
use Illuminate\Http\Request;

class EmployeeServicesController extends Controller
{

    Public function index(){
        return view('employee_s.employee_s');
    }
    public function service()
    {
        $services = ProvidedService::with('service', 'patient')
            ->select('provided_services.*') // ✅ هذا أهم سطر
            ->where('needed', 1)
            ->where('status', 'pending')
            ->join('services', 'services.id', '=', 'provided_services.service_id')
            ->where('services.user_id', auth()->id())
            ->get();

        return view('employee_s.service', compact('services'));
    }

    public function service_done()
    {
        $services = ProvidedService::with('service', 'patient')
            ->select('provided_services.*') // ✅ برضو هون
            ->where('needed', 1)
            ->where('status', 'scheduled')
            ->join('services', 'services.id', '=', 'provided_services.service_id')
            ->where('services.user_id', auth()->id())
            ->get();

        $servicedone = ProvidedService::with('service', 'patient')
            ->select('provided_services.*') // ✅ وهون كمان
            ->where('needed', 1)
            ->where('status', 'completed')
            ->join('services', 'services.id', '=', 'provided_services.service_id')
            ->where('services.user_id', auth()->id())
            ->get();

        return view('employee_s.servicedone', compact('services', 'servicedone'));
    }




    public function start($id)
    {
        $services = ProvidedService::findOrFail($id);

        $services->update([
            'start_date' => now(),
            'status' => 'scheduled',
        ]);


        return back()->with('success', 'تم تحديث وقت بدء الخدمة.');
    }

    public function complete($id)
    {
        $services = ProvidedService::findOrFail($id);

        $services->update([
            'end_date' => now(),
            'status' => 'completed',
        ]);

        return back()->with('success', 'تم تحديث وقت انتهاء الخدمة.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\DisabilityCause;
use App\Models\DisabilityType;
use App\Models\FamilyMember;
use App\Models\Grade;
use App\Models\Mother;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function employee()
    {
        if (Auth::check() && Auth::user()->role == "employee") {
            return view('employee.employee');
        }
        return 'يرجى تسجيل الدخول';
    }

    public function filterByDisability(Request $request)
    {
        $disabilityTypes = DisabilityType::all();


        $disabilityPatients = collect(); // نتائج حسب نوع الإعاقة


        // فلترة حسب نوع الإعاقة فقط
        if ($request->filled('disability_type_id')) {
            $disabilityPatients = Patient::where('disability_type_id', $request->disability_type_id)->get();
        }

        return view('employee.sort', compact(
            'disabilityTypes',

            'disabilityPatients',
        ));
    }
    public function filterByarea(Request $request)
    {

        $areas = Area::all();
        $areaPatients = collect();       // نتائج حسب المنطقة

        // فلترة حسب المنطقة فقط
        if ($request->filled('area_id')) {
            $userIds = User::where('area_id', $request->area_id)->pluck('id');
            $areaPatients = Patient::whereIn('user_id', $userIds)->get();
        }

        return view('employee.sort2', compact(

            'areas',
            'areaPatients'
        ));
    }



    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        $motherId = $patient->mother_id;
        $familyId = Mother::where('id', $motherId)->value('family_id');
        $members = FamilyMember::where('family_id', $familyId)->get();

        return view('employee.show', [ // ملف View خاص للموظف
            'disability_types' => DisabilityType::all(),
            'disability_causes' => DisabilityCause::all(),
            'patient' => $patient,
            'grades' => Grade::all(),
            'members' => $members,
        ]);

    }

}

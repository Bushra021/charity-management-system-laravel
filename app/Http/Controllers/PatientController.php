<?php

namespace App\Http\Controllers;


use App\Models\DisabilityCause;
use App\Models\DisabilityType;
use App\Models\FamilyMember;
use App\Models\Grade;
use App\Models\Mother;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{

    public function patient()
    {
        $user = Auth::user();

        if (!$user || $user->role !== "patient") {
            return redirect()->route('log_form');
        }


        if (!$user->patient || !$user->patient->profile_completed) {
            return redirect()->route('families.create');
        }

        return view('patient.patient');

    }

    public function create(Request $request)
    {
        try {
            $motherId = Crypt::decryptString($request->query('mother_id'));
        } catch (\Exception $e) {
            abort(403, 'رابط غير صالح');
        }

        return view('patient.info_1', [
            'disability_types' => DisabilityType::all(),
            'disability_causes' => DisabilityCause::all(),
            'mother_id' => $motherId,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([

                'name' => 'required|string|max:100|regex:/^[\p{Arabic}\s]+$/u',
                'birth_date' => 'required|date|before:today',
                'disability_type_id' => 'required|exists:disability_types,id',
                'disability_cause_id' => 'required|exists:disability_causes,id',
                'national_id' => 'required|digits:9|unique:patients,national_id',
                'injury_date' => 'required|date|before:today',
                'toilet_facilities' => 'required|in:خارجي,داخلي',
                'water_source' => 'required|string|regex:/^[\p{Arabic}\s]+$/u',
                'electricity_source' => 'required|string|regex:/^[\p{Arabic}\s]+$/u',
                'family_order' => 'required|integer|min:1',
                'relationship_to_head' => 'required|string|max:50|regex:/^[\p{Arabic}\s]+$/u',
                'disabled_person_residence' => 'required|in:داخل الأسرة,داخل مؤسسة,عند الأقارب',
                'education_reason' => 'nullable|string',
                'education_type' => 'nullable|in:مركز تربية خاصة,مدرسة عامة,جامعة',
                'unwra_card_number' => 'nullable|digits:8',
                'employment_type' => 'nullable|in:جزئي,كلي',
                'job_type' => 'nullable|string|regex:/^[\p{Arabic}\s]+$/u',
                'employment_method' => 'nullable|string|regex:/^[\p{Arabic}\s]+$/u',
                'vocational_training' => 'boolean',
                'social_case_responsible' => 'boolean',
                'disability_union_responsible' => 'nullable|boolean',
                'employment_status' => 'required|in:يعمل,لا يعمل',
                'refugee_status' => 'boolean',
                'education_status' => 'boolean',
                'training_location' => 'nullable|string|regex:/^[\p{Arabic}\s]+$/u',
                'training_type' => 'nullable|string|regex:/^[\p{Arabic}\s]+$/u',
                'social_case_responsible_relation' => 'nullable|string|regex:/^[\p{Arabic}\s]+$/u',
                'permanent_disability_percentage' => 'nullable|numeric|min:0|max:100',
                'phone_number' => 'nullable|regex:/^05\d{8}$/',
                //'fax_number' => 'nullable|regex:/^(02|03|09)\d{7}$/',
                'self_dependence_level' => 'nullable|string',
                'monthly_income' => 'required|numeric|min:0',
                'social_status' => 'required|in:أعزب,متزوج,مطلق,أرمل',
        ]);



        $patient = Patient::create([
            'mother_id' => $request->mother_id,
            'user_id'=> auth()->id(), // أو أي منطق خاص بك
            'disability_type_id' => $request->disability_type_id,
            'disability_cause_id' => $request->disability_cause_id,
            'national_id' => $request->national_id,
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'social_status' => $request->social_status,
            'injury_date' => $request->injury_date,
            'toilet_facilities' => $request->toilet_facilities,
            'water_source' => $request->water_source,
            'electricity_source' => $request->electricity_source,
            'family_order' => $request->family_order,
            'relationship_to_head' => $request->relationship_to_head,
            'disabled_person_residence' => $request->disabled_person_residence,
            'education_reason' => $request->education_reason,
            'education_type' => $request->education_type,
            'unwra_card_number' => $request->unwra_card_number,
            'employment_type' => $request->employment_type,
            'job_type' => $request->job_type,
            'employment_method' => $request->employment_method,
            'vocational_training' => $request->vocational_training,
            'social_case_responsible' => $request->social_case_responsible,
            'disability_union_responsible' => $request->disability_union_responsible,
            'employment_status' => $request->employment_status,
            'refugee_status' => $request->refugee_status,
            'education_status' => $request->education_status,
            'training_location' => $request->training_location,
            'training_type' => $request->training_type,
            'social_case_responsible_relation' => $request->social_case_responsible_relation,
            'permanent_disability_percentage' => $request->permanent_disability_percentage,
            'phone_number' => $request->phone_number,
            'fax_number' => $request->fax_number,
            'self_dependence_level' => $request->self_dependence_level,
            'monthly_income' => $request->monthly_income,


        ]);

        $requiredFields = [
            'name', 'birth_date', 'disability_type_id', 'disability_cause_id', 'national_id', 'injury_date',
            'toilet_facilities', 'water_source', 'electricity_source', 'family_order', 'relationship_to_head',
            'disabled_person_residence', 'social_status', 'self_dependence_level', 'monthly_income'
        ];

        $isProfileCompleted = true;
        foreach ($requiredFields as $field) {
            if (empty($request->$field)) {
                $isProfileCompleted = false;
                break;
            }
        }


        $patient->profile_completed = $isProfileCompleted;
        $patient->save();

        return redirect()->route('patient')->with('success', 'تم تسجيل المريض بنجاح!');

    }
    public function createprofile()
    {
        $patient = Patient::where('user_id', auth()->id())->first();
        $motherId = Patient::where('user_id', auth()->id())->value('mother_id');
        $familyId = Mother::where('id', $motherId)->value('family_id');

        $members = FamilyMember::where('family_id', $familyId)->get();
        return view('patient.profile_info', [
            'disability_types' => DisabilityType::all(),
            'disability_causes' => DisabilityCause::all(),
            'patient' => $patient,
            'grades' => Grade::all(),
            'members' => $members,

        ]);
    }


    public function updateField(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $field = $request->input('field');
        $value = $request->input('value');

        // تحقق أن الحقل من الحقول المسموح بتحديثها
        $allowedFields = [
            'name', 'birth_date', 'disability_type_id', 'disability_cause_id',
            'national_id', 'injury_date', 'toilet_facilities', 'water_source', 'electricity_source',
            'family_order', 'relationship_to_head', 'disabled_person_residence', 'education_reason',
            'education_type', 'unwra_card_number', 'employment_type', 'job_type', 'employment_method',
            'vocational_training', 'social_case_responsible', 'disability_union_responsible', 'employment_status',
            'refugee_status', 'education_status', 'training_location', 'training_type',
            'social_case_responsible_relation', 'permanent_disability_percentage',
            'phone_number', 'fax_number', 'self_dependence_level', 'monthly_income', 'social_status',

        ];

        if (!in_array($field, $allowedFields)) {
            return response()->json(['success' => false, 'message' => 'حقل غير مسموح به'], 400);
        }

        // تجهيز قواعد التحقق
        $rules = [
            'name' => 'required|string|max:100|regex:/^[\p{Arabic}\s]+$/u',
            'birth_date' => 'required|date|before:today',
            'disability_type_id' => 'required|exists:disability_types,id',
            'disability_cause_id' => 'required|exists:disability_causes,id',
            'national_id' => 'required|digits:9|unique:patients,national_id',
            'injury_date' => 'required|date|before:today',
            'toilet_facilities' => 'required|in:خارجي,داخلي',
            'water_source' => 'required|string|regex:/^[\p{Arabic}\s]+$/u',
            'electricity_source' => 'required|string|regex:/^[\p{Arabic}\s]+$/u',
            'family_order' => 'required|integer|min:1',
            'relationship_to_head' => 'required|string|max:50|regex:/^[\p{Arabic}\s]+$/u',
            'disabled_person_residence' => 'required|in:داخل الأسرة,داخل مؤسسة,عند الأقارب',
            'education_reason' => 'nullable|string',
            'education_type' => 'nullable|in:مركز تربية خاصة,مدرسة عامة,جامعة',
            'unwra_card_number' => 'nullable|digits:8',
            'employment_type' => 'nullable|in:جزئي,كلي',
            'job_type' => 'nullable|string|regex:/^[\p{Arabic}\s]+$/u',
            'employment_method' => 'nullable|string|regex:/^[\p{Arabic}\s]+$/u',
            'vocational_training' => 'boolean',
            'social_case_responsible' => 'boolean',
            'disability_union_responsible' => 'nullable|boolean',
            'employment_status' => 'required|in:يعمل,لا يعمل',
            'refugee_status' => 'boolean',
            'education_status' => 'boolean',
            'training_location' => 'nullable|string|regex:/^[\p{Arabic}\s]+$/u',
            'training_type' => 'nullable|string|regex:/^[\p{Arabic}\s]+$/u',
            'social_case_responsible_relation' => 'nullable|string|regex:/^[\p{Arabic}\s]+$/u',
            'permanent_disability_percentage' => 'nullable|numeric|min:0|max:100',
            'phone_number' => 'nullable|regex:/^05\d{8}$/',
            //'fax_number' => 'nullable|regex:/^(02|03|09)\d{7}$/',
            'self_dependence_level' => 'nullable|string',
            'monthly_income' => 'required|numeric|min:0',
            'social_status' => 'required|in:أعزب,متزوج,مطلق,أرمل',


        ];


        $validated = Validator::make(
            [$field => $value],
            [$field => $rules[$field] ?? []]
        );

        if ($validated->fails()) {
            return response()->json(['success' => false, 'errors' => $validated->errors()], 422);
        }

        return response()->json(['success' => true]);
    }




}


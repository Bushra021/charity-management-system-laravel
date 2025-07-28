<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class MotherController extends Controller

{
    public function create(Request $request)
    {
        try {
            $familyId = Crypt::decryptString($request->query('family_id'));
        } catch (\Exception $e) {
            abort(403, 'رابط غير صالح');
        }
        return view('patient.info_2', compact('familyId'));
    }

    public function checkMother($nationalId)
    {
        $mother = Mother::where('national_id', $nationalId)->first();
        return response()->json([
            'exists' => $mother ? true : false,
            'mother_id' => $mother ? Crypt::encryptString($mother->id) : null]);
    }

    public function store(Request $request)
    {
        // قواعد التحقق من البيانات
        $validatedData = $request->validate([
            'family_id' => 'required|exists:families,id', // تحقق من وجود العائلة
            'name' => 'required|string|max:100|regex:/^[\p{Arabic}\s]+$/u',
            'birth_date' => 'required|date|before:today', // تحقق من أن تاريخ الميلاد لا يمكن أن يكون اليوم أو بعده
            'health_status' => 'required|string|max:100',
            'academic_level' => 'required|in:ابتدائي,إعدادي,ثانوي,دبلوم,بكالوريا,جامعي,دراسات عليا',
            'profession' => 'nullable|string|max:100|regex:/^[\p{Arabic}\s]+$/u',
            'marriages_count' => 'nullable|integer|min:1',
            'national_id' => 'required|numeric|digits:9|unique:mothers,national_id',
            'relationship_with_father' => 'required|string|max:50|regex:/^[\p{Arabic}\s]+$/u',
            'has_disabilities' => 'nullable|boolean',
            'had_diseases_during_pregnancy' => 'nullable|boolean',
            'had_accidents_during_pregnancy' => 'nullable|boolean',
            'smoked_during_pregnancy' => 'nullable|boolean',
            'visited_doctor_during_pregnancy' => 'nullable|boolean',
            'disability_family' => 'nullable|boolean',
        ]);


        $booleanFields = [
            'has_disabilities',
            'had_diseases_during_pregnancy',
            'had_accidents_during_pregnancy',
            'smoked_during_pregnancy',
            'visited_doctor_during_pregnancy',
            'disability_family'
        ];

        foreach ($booleanFields as $field) {
            if (!isset($validatedData[$field])) {
                $validatedData[$field] = false;
            }
        }

        // إنشاء السجل في قاعدة البيانات
        $mother = Mother::create([
            'family_id' => $validatedData['family_id'],
            'name' => $validatedData['name'],
            'birth_date' => $validatedData['birth_date'],
            'health_status' => $validatedData['health_status'],
            'academic_level' => $validatedData['academic_level'],
            'profession' => $validatedData['profession'],
            'marriages_count' => $validatedData['marriages_count'],
            'national_id' => $validatedData['national_id'],
            'relationship_with_father' => $validatedData['relationship_with_father'],
            'has_disabilities' => $validatedData['has_disabilities'],
            'had_diseases_during_pregnancy' => $validatedData['had_diseases_during_pregnancy'],
            'had_accidents_during_pregnancy' => $validatedData['had_accidents_during_pregnancy'],
            'smoked_during_pregnancy' => $validatedData['smoked_during_pregnancy'],
            'visited_doctor_during_pregnancy' => $validatedData['visited_doctor_during_pregnancy'],
            'disability_family' => $validatedData['disability_family'],
        ]);

        // العودة برسالة نجاح
        return redirect()->route('patients.create', ['mother_id' => Crypt::encryptString($mother->id)]);
    }


    public function createprofile()
    {
        $patient = Patient::with('mother')
            ->where('user_id', auth()->id())
            ->first();

        if (!$patient) {
            // مثلاً ترجعه إلى الصفحة السابقة برسالة خطأ
            return redirect()->back()->with('error', 'لم يتم العثور على بيانات المريض.');
        }

        // الحصول على العائلة
        $mother = $patient->mother ?? null;

        return view('patient.profile_info', [
            'patient' => $patient,
            'mother' => $mother, // لو احتجته بالعرض
        ]);
    }

    public function updateField(Request $request, $id)
    {
        $mother = Mother::findOrFail($id);

        $field = $request->input('field');
        $value = $request->input('value');

        $allowedFields = [
            'national_id', 'name', 'birth_date', 'health_status',
            'academic_level', 'profession', 'marriages_count',
            'relationship_with_father', 'has_disabilities',
            'had_diseases_during_pregnancy', 'had_accidents_during_pregnancy',
            'smoked_during_pregnancy', 'visited_doctor_during_pregnancy',
            'disability_family',
        ];

        if (!in_array($field, $allowedFields)) {
            return response()->json(['success' => false, 'message' => 'حقل غير مسموح به'], 400);
        }

        $rules = [
            'name' => ['required','string', 'max:100', 'regex:/^[\p{Arabic}\s]+$/u'],
            'birth_date' => 'required|date|before:today',
            'health_status' => ['required', 'string', 'max:100', 'regex:/^[\p{Arabic}\s]+$/u'],
            'academic_level' => 'required|in:ابتدائي,إعدادي,ثانوي,دبلوم,بكالوريا,جامعي,دراسات عليا',
            'profession' => ['nullable', 'string', 'max:100', 'regex:/^[\p{Arabic}\s]+$/u'],
            'marriages_count' => 'nullable|integer|min:0',
            'national_id' => 'required|numeric|digits:9|unique:mothers,national_id,' . $id,
            'relationship_with_father' => ['required', 'string', 'max:50', 'regex:/^[\p{Arabic}\s]+$/u'],
            'has_disabilities' => 'nullable|boolean',
            'had_diseases_during_pregnancy' => 'nullable|boolean',
            'had_accidents_during_pregnancy' => 'nullable|boolean',
            'smoked_during_pregnancy' => 'nullable|boolean',
            'visited_doctor_during_pregnancy' => 'nullable|boolean',
            'disability_family' => 'nullable|boolean',
        ];

        $validated = Validator::make(
            [$field => $value],
            [$field => $rules[$field] ?? []]
        );

        if ($validated->fails()) {
            return response()->json(['success' => false, 'errors' => $validated->errors()], 422);
        }

        $mother->$field = $value;
        $mother->save();

        return response()->json(['success' => true]);
    }


}

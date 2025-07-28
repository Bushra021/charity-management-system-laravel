<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;


class FamilyController extends Controller
{

    public function create()
    {

        return view('patient.info3');
    }

    public function checkFather($nationalId)
    {
        $family = Family::where('national_id', $nationalId)->first();

        return response()->json([
            'exists' => $family ? true : false,
            'family_id' => $family ? Crypt::encryptString($family->id) : null
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([

            'national_id' => 'required|digits:9|unique:patients,national_id',
            'name' => 'required|string|max:100|regex:/^[\p{Arabic}\s]+$/u',
            'birth_date' => 'required|date|before:today',
            'health_status' => 'required|string|regex:/^[\p{Arabic}\s]+$/u',
            'academic_level' => 'required|in:ابتدائي,إعدادي,ثانوي,دبلوم,بكالوريا,جامعي,دراسات عليا',
            'profession' => 'nullable|string|max:100|regex:/^[\p{Arabic}\s]+$/u',
            'marriages_count' => 'required|integer|min:1',
            'has_disabilities' => 'nullable|boolean',
            'disability_family' => 'nullable|boolean',
            'family_type' => 'required|in:ممتدة,نووية',
            'has_health_insurance' => 'nullable|boolean',
            'health_insurance_reason' => 'nullable|string|max:255|regex:/^[\p{Arabic}\s]+$/u',
            'has_rehabilitation_centers' => 'nullable|boolean',
            'healthy_adults_count' => 'nullable|integer|min:0',
            'annual_income' => 'required|numeric|min:0',
            'house_ownership' => 'required|in:إيجار,ملك',
            'room_count' => 'required|integer|min:0',
            'monthly_rent' => 'nullable|numeric|min:0',
            'phone' => 'required|string|regex:/^\+?\d{10,15}$/',

        ]);


        // 🔍 التحقق من الأب
        $family = Family::where('national_id', $request->national_id)->first();

        if (!$family) {

            $family = Family::create([
                'name' => $request->input('name'),
                'national_id' => $request->input('national_id'),
                'birth_date' => $request->input('birth_date'),
                'phone' => $request->input('phone'),
                'health_status' => $request->input('health_status'),
                'academic_level' => $request->input('academic_level'),
                'profession' => $request->input('profession'),
                'marriages_count' => $request->input('marriages_count', 1),
                'has_disabilities' => $request->boolean('has_disabilities', false),
                'disability_family' => $request->boolean('disability_family', false),
                'family_type' => $request->input('family_type'),
                'has_health_insurance' => $request->boolean('has_health_insurance', false),
                'health_insurance_reason' => $request->input('health_insurance_reason'),
                'has_rehabilitation_centers' => $request->boolean('has_rehabilitation_centers', false),
                'healthy_adults_count' => $request->input('healthy_adults_count', 1),
                'annual_income' => $request->input('annual_income'),
                'house_ownership' => $request->input('house_ownership'),
                'room_count' => $request->input('room_count', 1),
                'monthly_rent' => $request->input('monthly_rent'),
            ]);
        }

        return redirect()->route('mothers.create', ['family_id' => Crypt::encryptString($family->id)]);


    }


    public function createprofile()
    {
        $patient = Patient::with('mother.family')
            ->where('user_id', auth()->id())
            ->first();

        if (!$patient) {
            // مثلاً ترجعه إلى الصفحة السابقة برسالة خطأ
            return redirect()->back()->with('error', 'لم يتم العثور على بيانات المريض.');
        }

        // الحصول على العائلة
        $family = $patient->mother->family ?? null;

        return view('patient.profile_info', [
            'patient' => $patient,
            'family' => $family, // لو احتجته بالعرض
        ]);
    }

    public function updateField(Request $request, $id)
    {
        \Log::info(['field' => $request->field, 'value' => $request->value]);

        /* ========== 1. جلب العائلة ========== */
        $family = Family::findOrFail($id);

        /* ========== 2. الحقل والقيمة المرسلة ========== */
        $field = $request->input('field');
        $value = $request->input('value');

        $allowed = [
            'national_id', 'name', 'birth_date', 'health_status', 'academic_level',
            'profession', 'marriages_count', 'has_disabilities', 'disability_family',
            'family_type', 'has_health_insurance', 'health_insurance_reason',
            'has_rehabilitation_centers', 'healthy_adults_count', 'annual_income',
            'house_ownership', 'room_count', 'monthly_rent',
        ];

        if (! in_array($field, $allowed, true)) {
            return response()->json(['success' => false, 'message' => 'حقل غير مسموح به'], 400);
        }

        /* ========== 3. قواعد التحقق ========== */
        $rules = [
            'national_id'              => ['required','digits:9','unique:families,national_id,'.$family->id],
            'name'                     => ['required','string','max:100','regex:/^[\p{Arabic}\s]+$/u'],
            'birth_date'              => ['required','date','before:today'],
            'health_status'           => ['required','string','regex:/^[\p{Arabic}\s]+$/u'],
            'academic_level'          => ['required','in:ابتدائي,إعدادي,ثانوي,دبلوم,بكالوريا,جامعي,دراسات عليا'],
            'profession'              => ['nullable','string','max:100','regex:/^[\p{Arabic}\s]+$/u'],
            'marriages_count'         => ['required','integer','min:1'],
            'has_disabilities'        => ['boolean'],
            'disability_family'       => ['boolean'],
            'family_type'             => ['required','in:ممتدة,نووية'],
            'has_health_insurance'    => ['boolean'],
            'health_insurance_reason' => ['nullable','string','max:255','regex:/^[\p{Arabic}\s]+$/u'],
            'has_rehabilitation_centers' => ['boolean'],
            'healthy_adults_count'    => ['nullable','integer','min:0'],
            'annual_income'           => ['required','numeric','min:0'],
            'house_ownership'         => ['required','in:إيجار,ملك'],
            'room_count'              => ['required','integer','min:0'],
            'monthly_rent'            => ['nullable','numeric','min:0'],
        ];

        /* ========== 4. رسائل الخطأ ========== */
        $messages = [
            'national_id.required' => 'رقم الهوية مطلوب.',
            'national_id.digits' => 'رقم الهوية يجب أن يتكون من 9 أرقام.',
            'national_id.unique' => 'رقم الهوية مستخدم مسبقاً.',

            'name.required' => 'اسم العائلة مطلوب.',
            'name.regex' => 'الاسم يجب أن يحتوي على أحرف عربية فقط.',

            'birth_date.required' => 'تاريخ الميلاد مطلوب.',
            'birth_date.date' => 'تاريخ الميلاد غير صالح.',
            'birth_date.before' => 'تاريخ الميلاد يجب أن يكون في الماضي.',

            'health_status.required' => 'الوضع الصحي مطلوب.',
            'health_status.regex' => 'الوضع الصحي يجب أن يكون باللغة العربية فقط.',

            'academic_level.required' => 'التحصيل العلمي مطلوب.',
            'academic_level.in' => 'التحصيل العلمي غير صالح.',

            'profession.regex' => 'المهنة يجب أن تكون باللغة العربية فقط.',

            'marriages_count.required' => 'عدد الزيجات مطلوب.',
            'marriages_count.integer' => 'عدد الزيجات يجب أن يكون رقماً صحيحاً.',
            'marriages_count.min' => 'عدد الزيجات يجب أن يكون 1 على الأقل.',

            'family_type.required' => 'نوع العائلة مطلوب.',
            'family_type.in' => 'نوع العائلة غير صالح.',

            'annual_income.required' => 'الدخل السنوي مطلوب.',
            'annual_income.numeric' => 'الدخل السنوي يجب أن يكون رقماً.',
            'annual_income.min' => 'الدخل السنوي لا يمكن أن يكون سالباً.',

            'room_count.required' => 'عدد الغرف مطلوب.',
            'room_count.integer' => 'عدد الغرف يجب أن يكون رقماً صحيحاً.',
            'room_count.min' => 'عدد الغرف لا يمكن أن يكون سالباً.',

            'monthly_rent.numeric' => 'قيمة الإيجار يجب أن تكون رقماً.',
            'monthly_rent.min' => 'قيمة الإيجار لا يمكن أن تكون سالبة.',

            'health_insurance_reason.regex' => 'سبب عدم وجود التأمين يجب أن يكون باللغة العربية فقط.',
        ];

        /* ========== 5. تنفيذ التحقق ========== */
        $validator = Validator::make(
            ['value' => $value],
            ['value' => $rules[$field] ?? ['nullable']]
        );
        $validator->setCustomMessages([
                'value' => $messages[$field . '.' . $rules[$field][0]] ?? 'القيمة غير صالحة.'
            ] + $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => [$field => $validator->errors()->all()],
            ], 422);
        }

        /* ========== 6. تكييف القيمة حسب نوع الحقل ========== */
        $booleanFields = [
            'has_disabilities', 'disability_family',
            'has_health_insurance', 'has_rehabilitation_centers'
        ];
        $integerFields = ['marriages_count', 'healthy_adults_count', 'room_count'];
        $numericFields = ['annual_income', 'monthly_rent'];

        if (in_array($field, $booleanFields, true)) {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        } elseif (in_array($field, $integerFields, true)) {
            $value = intval($value);
        } elseif (in_array($field, $numericFields, true)) {
            $value = floatval($value);
        }

        /* ========== 7. تحديث السجل ========== */
        $family->update([$field => $value]);

        /* ========== 8. ردّ ناجح مع القيمة الجديدة ========== */
        return response()->json([
            'success' => true,
            'value'   => $value,
        ]);
    }


}



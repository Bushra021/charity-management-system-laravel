<?php

namespace App\Http\Controllers;

use App\Models\Effect;
use App\Models\Grade;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EffectController extends Controller
{
    public function create()
    {

        return view('effect.effect', [
            'grades' => Grade::all(),
        ]);

    }


    public function store(Request $request)
    {
        /* رسائل الخطأ المخصَّصة */
        $messages = [
            // الرسائل العامة
            'required' => 'هذا الحقل مطلوب.',
            'integer'  => 'يجب اختيار قيمة صحيحة.',
            'exists'   => 'القيمة المختارة غير صالحة.',

            // رسائل مخصّصة لكل حقل (اختياري إن أردت تخصيصاً أدق)
            'health_physical.required'        => 'درجة الصحة الجسدية مطلوبة.',
            'health_physical.exists'          => 'درجة الصحة الجسدية غير موجودة.',
            'health_mental.required'          => 'درجة الصحة الذهنية مطلوبة.',
            'health_psychological.required'   => 'درجة الصحة النفسية مطلوبة.',
            'education.required'              => 'درجة التعليم مطلوبة.',
            'marital_life.required'           => 'درجة الحياة الزوجية مطلوبة.',
            'social_activities.required'      => 'درجة الأنشطة الاجتماعية مطلوبة.',
            'social_skills.required'          => 'درجة المهارات الاجتماعية مطلوبة.',
            'self_management.required'        => 'درجة إدارة الذات مطلوبة.',
            'family_relationship.required'    => 'درجة العلاقة الأسرية مطلوبة.',
            'work.required'                   => 'درجة العمل مطلوبة.',
            'financial_independence.required' => 'درجة الاستقلال المالي مطلوبة.',
            'public_life.required'            => 'درجة الحياة العامة مطلوبة.',
        ];

        /* التحقق من صحة البيانات */
        $validated = $request->validate([
            'health_physical'        => 'required|integer|exists:grades,id',
            'health_mental'          => 'required|integer|exists:grades,id',
            'health_psychological'   => 'required|integer|exists:grades,id',
            'education'              => 'required|integer|exists:grades,id',
            'marital_life'           => 'required|integer|exists:grades,id',
            'social_activities'      => 'required|integer|exists:grades,id',
            'social_skills'          => 'required|integer|exists:grades,id',
            'self_management'        => 'required|integer|exists:grades,id',
            'family_relationship'    => 'required|integer|exists:grades,id',
            'work'                   => 'required|integer|exists:grades,id',
            'financial_independence' => 'required|integer|exists:grades,id',
            'public_life'            => 'required|integer|exists:grades,id',
        ], $messages);   // ← تمرير الرسائل هنا

        /* الحصول على معرف المريض المرتبط بالمستخدم الحالي */
        $patientId = Patient::where('user_id', auth()->id())->value('id');

        /* منع التكرار */
        if (Effect::where('patient_id', $patientId)->exists()) {
            return back()
                ->withErrors(['error' => 'تم تسجيل هذه التأثيرات من قبل.'])
                ->withInput();
        }

        /* إنشاء السجل */
        Effect::create([
            'patient_id'             => $patientId,
            'health_physical'        => $validated['health_physical'],
            'health_mental'          => $validated['health_mental'],
            'health_psychological'   => $validated['health_psychological'],
            'education'              => $validated['education'],
            'marital_life'           => $validated['marital_life'],
            'social_activities'      => $validated['social_activities'],
            'social_skills'          => $validated['social_skills'],
            'self_management'        => $validated['self_management'],
            'family_relationship'    => $validated['family_relationship'],
            'work'                   => $validated['work'],
            'financial_independence' => $validated['financial_independence'],
            'public_life'            => $validated['public_life'],
        ]);

        return redirect()->route('patient')->with('success', 'تم تسجيل التأثيرات بنجاح!');
    }

    /* ================================================= */

    public function createprofile()
    {
        $patient = auth()->user()->patient;           // جلب المريض الحالي
        $effect  = Effect::where('patient_id', $patient->id)->first();

        if ($effect) {
            return view('patient.profile_info', [
                'grades'  => Grade::all(),
                'effect'  => $effect,
                'patient' => $patient,
            ]);
        }

        // لو لم يوجد سجل تأثير، إعادة توجيه لإنشائه
        return redirect()
            ->route('effect.create')
            ->with('info', 'يرجى إدخال بيانات التأثيرات أولاً.');
    }


    public function updateField(Request $request, $id)
    {
        $patient = Patient::with('effect ')->findOrFail($id);

        $field = $request->input('field');

        $value = $request->input('value');
        $allowedFields = [
            'health_physical',
            'health_mental',
            'health_psychological',
            'education',
            'marital_life',
            'social_activities',
            'social_skills',
            'self_management',
            'family_relationship',
            'work',
            'financial_independence',
            'public_life',
        ];


        if (!in_array($field, $allowedFields)) {
            return response()->json(['success' => false, 'message' => 'حقل غير مسموح به'], 400);
        }

        $rules = [
            'health_physical' => 'required|integer|exists:grades,id',
            'health_mental' => 'required|integer|exists:grades,id',
            'health_psychological' => 'required|integer|exists:grades,id',
            'education' => 'required|integer|exists:grades,id',
            'marital_life' => 'required|integer|exists:grades,id',
            'social_activities' => 'required|integer|exists:grades,id',
            'social_skills' => 'required|integer|exists:grades,id',
            'self_management' => 'required|integer|exists:grades,id',
            'family_relationship' => 'required|integer|exists:grades,id',
            'work' => 'required|integer|exists:grades,id',
            'financial_independence' => 'required|integer|exists:grades,id',
            'public_life' => 'required|integer|exists:grades,id',
        ];

        $validated = Validator::make(
            [$field => $value],
            [$field => $rules[$field] ?? []]
        );

        if ($validated->fails()) {
            return response()->json(['success' => false, 'errors' => $validated->errors()], 422);
        }

        // ✅ تحديث البيانات
        $effect = $patient->effect ?? null;

        if (!$effect) {
            return response()->json(['success' => false, 'message' => 'لا توجد عائلة مرتبطة'], 404);
        }

        $effect->$field = $value;
        $effect->save();

        return response()->json(['success' => true]);
    }

}

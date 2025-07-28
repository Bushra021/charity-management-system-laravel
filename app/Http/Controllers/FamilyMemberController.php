<?php

namespace App\Http\Controllers;

use App\Models\DisabilityCause;
use App\Models\DisabilityType;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Grade;
use App\Models\Mother;
use App\Models\Patient;
use Illuminate\Http\Request;

class FamilyMemberController extends Controller
{

    public function show()
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

    public function create()
    {
        return view('member.create');
    }


    public function store(Request $request)
    {
        /* رسائل الخطأ المخصَّصة */
        $messages = [
            // المصفوفة الرئيسة
            'members.required' => 'يجب إضافة فرد واحد على الأقل.',
            'members.array'    => 'تنسيق البيانات غير صحيح.',
            'members.min'      => 'يجب إضافة فرد واحد على الأقل.',

            // الاسم
            'members.*.name.required' => 'الاسم مطلوب لكل فرد.',
            'members.*.name.string'   => 'الاسم يجب أن يكون نصًّا.',
            'members.*.name.max'      => 'الاسم لا يجوز أن يتجاوز 100 حرف.',

            // سنة الميلاد
            'members.*.birth_year.required' => 'سنة الميلاد مطلوبة لكل فرد.',
            'members.*.birth_year.digits'   => 'سنة الميلاد يجب أن تتكوّن من 4 أرقام.',
            'members.*.birth_year.integer'  => 'سنة الميلاد يجب أن تكون رقمًا صحيحًا.',
            'members.*.birth_year.min'      => 'سنة الميلاد يجب ألا تقل عن 1900.',
            'members.*.birth_year.max'      => 'سنة الميلاد لا يمكن أن تتجاوز السنة الحالية.',

            // صلة القرابة
            'members.*.relationship.required' => 'صلة القرابة مطلوبة لكل فرد.',
            'members.*.relationship.in'       => 'صلة القرابة يجب أن تكون: أخت، أخ، ابن، ابنة، زوجة أو زوج.',

            // الحالة الاجتماعية
            'members.*.social_status.required' => 'الحالة الاجتماعية مطلوبة لكل فرد.',
            'members.*.social_status.in'       => 'الحالة الاجتماعية يجب أن تكون: أعزب، متزوج، مطلق أو أرمل.',

            // التحصيل العلمي
            'members.*.academic_level.required' => 'التحصيل العلمي مطلوب لكل فرد.',
            'members.*.academic_level.in'       => 'التحصيل العلمي يجب أن يكون: ابتدائي، إعدادي، ثانوي، دبلوم، جامعي أو دراسات عليا.',

            // الوضع الصحي
            'members.*.health_status.required' => 'الوضع الصحي مطلوب لكل فرد.',
            'members.*.health_status.string'   => 'الوضع الصحي يجب أن يكون نصًّا.',

            // الإعاقة
            'members.*.has_disability.required' => 'حقل الإعاقة مطلوب لكل فرد.',
            'members.*.has_disability.boolean'  => 'قيمة حقل الإعاقة يجب أن تكون صحيحة (0 أو 1).',
        ];

        /* التحقق من صحة البيانات */
        $validated = $request->validate([
            'members'                      => 'required|array|min:1',
            'members.*.name'               => 'required|string|max:100',
            'members.*.birth_year'         => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'members.*.relationship'       => 'required|in:أخت,أخ,ابن,ابنة,زوجة,زوج',
            'members.*.social_status'      => 'required|in:أعزب,متزوج,مطلق,أرمل',
            'members.*.academic_level'     => 'required|in:ابتدائي,إعدادي,ثانوي,دبلوم,جامعي,دراسات عليا',
            'members.*.health_status'      => 'required|string',
            'members.*.has_disability'     => 'required|boolean',
        ], $messages);   // <-- هنا تمرير الرسائل المخصَّصة

        /* استخراج معرف العائلة */
        $motherId = Patient::where('user_id', auth()->id())->value('mother_id');
        $familyId = Mother::where('id', $motherId)->value('family_id');

        /* تخزين كل فرد */
        foreach ($validated['members'] as $member) {
            FamilyMember::create([
                'family_id'       => $familyId,
                'name'            => $member['name'],
                'birth_year'      => $member['birth_year'],
                'relationship'    => $member['relationship'],
                'social_status'   => $member['social_status'],
                'academic_level'  => $member['academic_level'],
                'health_status'   => $member['health_status'],
                'has_disability'  => $member['has_disability'],
            ]);
        }

        return redirect()->route('member.show')
            ->with('success', 'تم تسجيل أفراد العائلة بنجاح!');
    }


    public function destroy($id)
    {
        $member = FamilyMember::findOrFail($id);
        $member->delete();

        return redirect()->back()->with('success', 'تم حذف الفرد بنجاح.');

    }
}




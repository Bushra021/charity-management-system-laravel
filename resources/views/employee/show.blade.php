@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">
@push('css')

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="{{asset('css/profile-info.css')}}" rel="stylesheet">

@endpush

@section('page')
    <div class="dashboard-container">
        <div class="sidebar">
            <h3>لوحة التحكم</h3>

            @php
                $role = auth()->user()->role;
            @endphp

    @if($role === 'employee_services')
        <a href="{{route('appointment.index')}}">المواعيد</a><br>
        <a href="{{route('search-patient')}}"> الملاحظات </a><br>
        <a href="{{route('employee.service')}}">الخدمات المطلوبة </a><br>
        <a href="{{route('employee.service done')}}">الخدمات الجارية والمنهية </a><br>


    @elseif($role === 'employee')
        <a href="{{route('exemption')}}">الادوات المطلوبة </a><br>
        <a href="{{route('exemption2')}}"> الادوات التي تم صرفها </a><br>
        <a href="{{route('employee.filter')}}"> الفرز حسب الاعاقة</a><br>
        <a href="{{route('employee.filter2')}}"> الفرز حسب المنطقة</a><br>
    @endif

    <a href="{{ route('profile.show') }}">معلومات الحساب</a><br>
    </div>
    <div class="main-content">
        <div class="header">
            <div class="user-name">مرحباً، {{ auth()->user()->name }}</div>
            <img src="{{ asset('storage/' . (Auth::user()->profile_picture ?? 'defaults/profile.jpg')) }}" width="150" alt="الصورة الشخصية">
            <div class="logout-btn">
                <a href="{{ route('logout') }}">تسجيل الخروج</a>
            </div>
        </div>

            <div class="container">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="patient-tab" data-bs-toggle="tab" data-bs-target="#patient" type="button" role="tab">معلومات المريض</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="father-tab" data-bs-toggle="tab" data-bs-target="#father" type="button" role="tab">معلومات الأب</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="mother-tab" data-bs-toggle="tab" data-bs-target="#mother" type="button" role="tab">معلومات الأم</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="family-tab" data-bs-toggle="tab" data-bs-target="#family" type="button" role="tab">معلومات العائلة</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="disability-tab" data-bs-toggle="tab" data-bs-target="#effect" type="button" role="tab">تأثير الإعاقة</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    {{--patient--}}
                    <div class="tab-pane fade show active" id="patient" role="tabpanel">
                        <h1> بيانات المريض</h1>
                        <div class="card">
                            <div class="card-body">
                                <form id="patientForm" enctype="multipart/form-data">
                                    {{-- الحقول النصية --}}
                                    @foreach ([
                                        'name' => 'الاسم الكامل',
                                        'birth_date' => 'تاريخ الميلاد',
                                        'injury_date' => 'تاريخ الإصابة',
                                        'water_source' => 'مصدر المياه',
                                        'electricity_source' => 'مصدر الكهرباء',
                                        'family_order' => 'ترتيب الأسرة',
                                        'relationship_to_head' => 'العلاقة برئيس الأسرة',
                                        'education_reason' => 'سبب عدم التعليم',
                                        'job_type' => 'نوع الوظيفة',
                                        'employment_method' => 'طريقة التوظيف',
                                        'training_location' => 'مكان التدريب',
                                        'training_type' => 'نوع التدريب',
                                        'social_case_responsible_relation' => 'العلاقة مع المسؤول الاجتماعي',
                                        'permanent_disability_percentage' => 'نسبة الإعاقة الدائمة',
                                        'monthly_income' => 'الدخل الشهري',
                                        'self_dependence_level' => 'مستوى الاعتماد على النفس',
                                        'medical_report' => 'التقرير الطبي'
                                    ] as $field => $label)
                                        <div class="mb-4">
                                            <label class="form-label">{{ $label }}</label>
                                            <div class="d-flex align-items-center">
                                                <span id="{{ $field }}_text" class="flex-grow-1">{{ $patient->$field ?? 'لا يوجد' }}</span>

                                                @if ($field === 'medical_report')
                                                    <input
                                                        type="file"
                                                        id="{{ $field }}_input"
                                                        class="form-control d-none flex-grow-1"
                                                        name="{{ $field }}"
                                                    >
                                                @else
                                                    <input
                                                        type="{{ in_array($field, ['birth_date', 'injury_date']) ? 'date' : 'text' }}"
                                                        id="{{ $field }}_input"
                                                        name="{{ $field }}"
                                                        class="form-control d-none flex-grow-1"
                                                        value="{{ old($field, $patient->$field) }}"
                                                    >
                                                @endif

                                            </div>
                                            <div id="{{ $field }}_error" class="text-danger small mt-1"></div>
                                        </div>
                                    @endforeach

                                    {{-- رقم الهوية --}}
                                    <div class="mb-4">
                                        <label class="form-label">رقم الهوية</label>
                                        <div class="d-flex align-items-center">
                                            <span id="national_id_text" class="flex-grow-1">{{ $patient->national_id }}</span>
                                            <input
                                                type="text"
                                                id="national_id_input"
                                                name="national_id"
                                                class="form-control d-none flex-grow-1"
                                                value="{{ old('national_id', $patient->national_id) }}"
                                                maxlength="9"
                                                pattern="\d{9}"
                                                title="يجب أن يكون 9 أرقام فقط"
                                            >

                                        </div>
                                        <div id="national_id_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- نوع الإعاقة --}}
                                    <div class="mb-4">
                                        <label class="form-label">نوع الإعاقة</label>
                                        <div class="d-flex align-items-center">
                                            <span id="disability_type_id_text" class="flex-grow-1">{{ optional($patient->disabilitytype)->name }}</span>
                                            <select id="disability_type_id_input" name="disability_type_id" class="form-control d-none flex-grow-1">
                                                @foreach($disability_types as $type)
                                                    <option value="{{ $type->id }}" {{ $patient->disability_type_id == $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="disability_type_id_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- سبب الإعاقة --}}
                                    <div class="mb-4">
                                        <label class="form-label">سبب الإعاقة</label>
                                        <div class="d-flex align-items-center">
                                            <span id="disability_cause_id_text" class="flex-grow-1">{{ optional($patient->disabilitycause)->name }}</span>
                                            <select id="disability_cause_id_input" name="disability_cause_id" class="form-control d-none flex-grow-1">
                                                @foreach($disability_causes as $cause)
                                                    <option value="{{ $cause->id }}" {{ $patient->disability_cause_id == $cause->id ? 'selected' : '' }}>
                                                        {{ $cause->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div id="disability_cause_id_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- مكان إقامة المعاق --}}
                                    <div class="mb-4">
                                        <label class="form-label">مكان إقامة المعاق</label>
                                        <div class="d-flex align-items-center">
                                            <span id="disabled_person_residence_text" class="flex-grow-1">{{ $patient->disabled_person_residence }}</span>
                                            <select id="disabled_person_residence_input" name="disabled_person_residence" class="form-control d-none flex-grow-1">
                                                @foreach(['داخل الأسرة', 'داخل مؤسسة', 'عند الأقارب'] as $residence)
                                                    <option value="{{ $residence }}" {{ $patient->disabled_person_residence == $residence ? 'selected' : '' }}>
                                                        {{ $residence }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div id="disabled_person_residence_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- مرافق المرحاض --}}
                                    <div class="mb-4">
                                        <label class="form-label">مرافق المرحاض</label>
                                        <div class="d-flex align-items-center">
                                            <span id="toilet_facilities_text" class="flex-grow-1">{{ $patient->toilet_facilities }}</span>
                                            <select id="toilet_facilities_input" name="toilet_facilities" class="form-control d-none flex-grow-1">
                                                @foreach(['خارجي', 'داخلي'] as $facility)
                                                    <option value="{{ $facility }}" {{ $patient->toilet_facilities == $facility ? 'selected' : '' }}>
                                                        {{ $facility }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="toilet_facilities_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- نوع التعليم --}}
                                    <div class="mb-4">
                                        <label class="form-label">نوع التعليم</label>
                                        <div class="d-flex align-items-center">
                                            <span id="education_type_text" class="flex-grow-1">{{ $patient->education_type }}</span>
                                            <select id="education_type_input" name="education_type" class="form-control d-none flex-grow-1">
                                                @foreach(['مركز تربية خاصة', 'مدرسة عامة', 'جامعة'] as $education)
                                                    <option value="{{ $education }}" {{ $patient->education_type == $education ? 'selected' : '' }}>
                                                        {{ $education }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="education_type_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- حالة العمل --}}
                                    <div class="mb-4">
                                        <label class="form-label">حالة العمل</label>
                                        <div class="d-flex align-items-center">
                                            <span id="employment_status_text" class="flex-grow-1">{{ $patient->employment_status }}</span>
                                            <select id="employment_status_input" name="employment_status" class="form-control d-none flex-grow-1">
                                                @foreach(['يعمل', 'لا يعمل'] as $status)
                                                    <option value="{{ $status }}" {{ $patient->employment_status == $status ? 'selected' : '' }}>
                                                        {{ $status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="employment_status_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- نوع العمل --}}
                                    <div class="mb-4">
                                        <label class="form-label">نوع العمل</label>
                                        <div class="d-flex align-items-center">
                                            <span id="employment_type_text" class="flex-grow-1">{{ $patient->employment_type }}</span>
                                            <select id="employment_type_input" name="employment_type" class="form-control d-none flex-grow-1">
                                                @foreach(['جزئي', 'كلي'] as $type)
                                                    <option value="{{ $type }}" {{ $patient->employment_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div id="employment_type_error" class="text-danger small mt-1"></div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">الحالة الاجتماعية</label>
                                        <div class="d-flex align-items-center">
                                            <span id="social_status_text" class="flex-grow-1">{{ $patient->social_status }}</span>
                                            <select id="social_status_input" name="social_status" class="form-control d-none flex-grow-1">
                                                @foreach(['أعزب', 'متزوج', 'أرمل', 'مطلق'] as $status)
                                                    <option value="{{ $status }}" {{ $patient->social_status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="social_status_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- حاصل على تدريب مهني --}}
                                    <div class="mb-4">
                                        <label class="form-label">حاصل على تدريب مهني</label>
                                        <div class="d-flex align-items-center">
                                            <span id="vocational_training_text" class="flex-grow-1">{{ $patient->vocational_training ? 'نعم' : 'لا' }}</span>
                                            <select id="vocational_training_input" name="vocational_training" class="form-control d-none flex-grow-1">
                                                <option value="1" {{ $patient->vocational_training == 1 ? 'selected' : '' }}>نعم</option>
                                                <option value="0" {{ $patient->vocational_training == 0 ? 'selected' : '' }}>لا</option>
                                            </select>

                                        </div>
                                        <div id="vocational_training_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- مكفول من الشؤون الاجتماعية --}}
                                    <div class="mb-4">
                                        <label class="form-label">مكفول من الشؤون الاجتماعية</label>
                                        <div class="d-flex align-items-center">
                                            <span id="social_case_responsible_text" class="flex-grow-1">{{ $patient->social_case_responsible ? 'نعم' : 'لا' }}</span>
                                            <select id="social_case_responsible_input" name="social_case_responsible" class="form-control d-none flex-grow-1">
                                                <option value="1" {{ $patient->social_case_responsible == 1 ? 'selected' : '' }}>نعم</option>
                                                <option value="0" {{ $patient->social_case_responsible == 0 ? 'selected' : '' }}>لا</option>
                                            </select>
                                        </div>
                                        <div id="social_case_responsible_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- مكفول من اتحاد المعاقين --}}
                                    <div class="mb-4">
                                        <label class="form-label">مكفول من اتحاد المعاقين</label>
                                        <div class="d-flex align-items-center">
                                            <span id="disability_union_responsible_text" class="flex-grow-1">{{ $patient->disability_union_responsible ? 'نعم' : 'لا' }}</span>
                                            <select id="disability_union_responsible_input" name="disability_union_responsible" class="form-control d-none flex-grow-1">
                                                <option value="1" {{ $patient->disability_union_responsible == 1 ? 'selected' : '' }}>نعم</option>
                                                <option value="0" {{ $patient->disability_union_responsible == 0 ? 'selected' : '' }}>لا</option>
                                            </select>
                                        </div>
                                        <div id="disability_union_responsible_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- حالة اللجوء --}}
                                    <div class="mb-4">
                                        <label class="form-label">حالة اللجوء</label>
                                        <div class="d-flex align-items-center">
                                            <span id="refugee_status_text" class="flex-grow-1">{{ $patient->refugee_status ? 'نعم' : 'لا' }}</span>
                                            <select id="refugee_status_input" name="refugee_status" class="form-control d-none flex-grow-1">
                                                <option value="1" {{ $patient->refugee_status == 1 ? 'selected' : '' }}>نعم</option>
                                                <option value="0" {{ $patient->refugee_status == 0 ? 'selected' : '' }}>لا</option>
                                            </select>
                                        </div>
                                        <div id="refugee_status_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- حالة التعليم --}}
                                    <div class="mb-4">
                                        <label class="form-label">حالة التعليم</label>
                                        <div class="d-flex align-items-center">
                                            <span id="education_status_text" class="flex-grow-1">{{ $patient->education_status ? 'نعم' : 'لا' }}</span>
                                            <select id="education_status_input" name="education_status" class="form-control d-none flex-grow-1">
                                                <option value="1" {{ $patient->education_status == 1 ? 'selected' : '' }}>نعم</option>
                                                <option value="0" {{ $patient->education_status == 0 ? 'selected' : '' }}>لا</option>
                                            </select>
                                        </div>
                                        <div id="education_status_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- رقم الهاتف --}}
                                    <div class="mb-4">
                                        <label class="form-label">رقم الهاتف</label>
                                        <div class="d-flex align-items-center">
                                            <span id="phone_number_text" class="flex-grow-1">{{ $patient->phone_number }}</span>
                                            <input
                                                type="text"
                                                id="phone_number_input"
                                                name="phone_number"
                                                class="form-control d-none flex-grow-1"
                                                value="{{ $patient->phone_number }}"
                                                maxlength="10"
                                                pattern="^05\d{8}$"
                                                title="رقم الهاتف يجب أن يبدأ بـ 05 ويليه 8 أرقام"
                                            >

                                        </div>
                                        <div id="phone_number_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- رقم الفاكس --}}
                                    <div class="mb-4">
                                        <label class="form-label">رقم الفاكس</label>
                                        <div class="d-flex align-items-center">
                                            <span id="fax_number_text" class="flex-grow-1">{{ $patient->fax_number }}</span>
                                            <input
                                                type="text"
                                                id="fax_number_input"
                                                name="fax_number"
                                                class="form-control d-none flex-grow-1"
                                                value="{{ $patient->fax_number }}"
                                                maxlength="9"
                                                pattern="^(02|03|09)\d{7}$"
                                                title="رقم الفاكس يجب أن يبدأ بـ 02 أو 03 أو 09 ويليه 7 أرقام"
                                            >
                                        </div>
                                        <div id="fax_number_error" class="text-danger small mt-1"></div>
                                    </div>

                                    {{-- رقم الأونروا --}}
                                    <div class="mb-4">
                                        <label class="form-label">رقم الأونروا</label>
                                        <div class="d-flex align-items-center">
                                            <span id="unwra_card_number_text" class="flex-grow-1">{{ $patient->unwra_card_number }}</span>
                                            <input
                                                type="text"
                                                id="unwra_card_number_input"
                                                name="unwra_card_number"
                                                class="form-control d-none flex-grow-1"
                                                value="{{ $patient->unwra_card_number }}"
                                                maxlength="8"
                                                pattern="\d{8}"
                                                title="يجب أن يكون 8 أرقام فقط"
                                            >
                                        </div>
                                        <div id="unwra_card_number_error" class="text-danger small mt-1"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- تبويب الأب --}}
                    <div class="tab-pane fade" id="father" role="tabpanel">
                        @php
                            $academic_levels = ['ابتدائي', 'إعدادي', 'ثانوي', 'دبلوم', 'بكالوريا', 'جامعي', 'دراسات عليا'];
                            $family_types = ['ممتدة', 'نووية'];
                            $house_ownerships = ['إيجار', 'ملك'];
                        @endphp

                        <div class="mb-4">
                            <label class="form-label">رقم الهوية</label>
                            <div class="d-flex align-items-center">
                                <span id="national_id_text" class="flex-grow-1">{{ $patient->mother->family->national_id }}</span>
                                <input type="text" id="national_id_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->family->national_id }}" maxlength="9" pattern="\d{9}" title="يجب أن يكون 9 أرقام فقط">

                            </div>
                            <div id="national_id_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">اسم العائلة</label>
                            <div class="d-flex align-items-center">
                                <span id="name_text" class="flex-grow-1">{{ $patient->mother->family->name }}</span>
                                <input type="text" id="name_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->family->name }}">

                            </div>
                            <div id="name_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">تاريخ الميلاد</label>
                            <div class="d-flex align-items-center">
                                <span id="birth_date_text" class="flex-grow-1">{{ $patient->mother->family->birth_date }}</span>
                                <input type="date" id="birth_date_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->family->birth_date }}">

                            </div>
                            <div id="birth_date_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">الحالة الصحية</label>
                            <div class="d-flex align-items-center">
                                <span id="health_status_text" class="flex-grow-1">{{ $patient->mother->family->health_status }}</span>
                                <input type="text" id="health_status_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->family->health_status }}">

                            </div>
                            <div id="health_status_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">المستوى الأكاديمي</label>
                            <div class="d-flex align-items-center">
                                <span id="academic_level_text" class="flex-grow-1">{{ $patient->mother->family->academic_level }}</span>
                                <select id="academic_level_input" class="form-control d-none flex-grow-1">
                                    @foreach($academic_levels as $level)
                                        <option value="{{ $level }}" {{ $patient->mother->family->academic_level == $level ? 'selected' : '' }}>{{ $level }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div id="academic_level_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">المهنة</label>
                            <div class="d-flex align-items-center">
                                <span id="profession_text" class="flex-grow-1">{{ $patient->mother->family->profession }}</span>
                                <input type="text" id="profession_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->family->profession }}">

                            </div>
                            <div id="profession_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">هل يوجد إعاقة؟</label>
                            <div class="d-flex align-items-center">
                                <span id="has_disabilities_text" class="flex-grow-1">{{ $patient->mother->family->has_disabilities ? 'نعم' : 'لا' }}</span>
                                <select id="has_disabilities_input" class="form-control d-none flex-grow-1">
                                    <option value="1" {{ $patient->mother->family->has_disabilities == true ? 'selected' : '' }}>نعم</option>
                                    <option value="0" {{ $patient->mother->family->has_disabilities == false ? 'selected' : '' }}>لا</option>
                                </select>
                            </div>
                            <div id="has_disabilities_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">هل يوجد إعاقة في العائلة؟</label>
                            <div class="d-flex align-items-center">
                                <span id="disability_family_text" class="flex-grow-1">{{ $patient->mother->family->disability_family ? 'نعم' : 'لا' }}</span>
                                <select id="disability_family_input" class="form-control d-none flex-grow-1">
                                    <option value="1" {{ $patient->mother->family->disability_family == true ? 'selected' : '' }}>نعم</option>
                                    <option value="0" {{ $patient->mother->family->disability_family == false ? 'selected' : '' }}>لا</option>
                                </select>

                            </div>
                            <div id="disability_family_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">نوع العائلة</label>
                            <div class="d-flex align-items-center">
                                <span id="family_type_text" class="flex-grow-1">{{ $patient->mother->family->family_type }}</span>
                                <select id="family_type_input" class="form-control d-none flex-grow-1">
                                    <option value="ممتدة" {{ $patient->mother->family->family_type == 'ممتدة' ? 'selected' : '' }}>ممتدة</option>
                                    <option value="نووية" {{ $patient->mother->family->family_type == 'نووية' ? 'selected' : '' }}>نووية</option>
                                </select>

                            </div>
                            <div id="family_type_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">هل يوجد تأمين صحي؟</label>
                            <div class="d-flex align-items-center">
                                <span id="has_health_insurance_text" class="flex-grow-1">{{ $patient->mother->family->has_health_insurance ? 'نعم' : 'لا' }}</span>
                                <select id="has_health_insurance_input" class="form-control d-none flex-grow-1">
                                    <option value="1" {{ $patient->mother->family->has_health_insurance == true ? 'selected' : '' }}>نعم</option>
                                    <option value="0" {{ $patient->mother->family->has_health_insurance == false ? 'selected' : '' }}>لا</option>
                                </select>

                            </div>
                            <div id="has_health_insurance_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">سبب التأمين الصحي</label>
                            <div class="d-flex align-items-center">
                                <span id="health_insurance_reason_text" class="flex-grow-1">{{ $patient->mother->family->health_insurance_reason }}</span>
                                <input type="text" id="health_insurance_reason_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->family->health_insurance_reason }}">

                            </div>
                            <div id="health_insurance_reason_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">هل توجد مراكز تأهيل؟</label>
                            <div class="d-flex align-items-center">
                                <span id="has_rehabilitation_centers_text" class="flex-grow-1">{{ $patient->mother->family->has_rehabilitation_centers ? 'نعم' : 'لا' }}</span>
                                <select id="has_rehabilitation_centers_input" class="form-control d-none flex-grow-1">
                                    <option value="1" {{ $patient->mother->family->has_rehabilitation_centers == true ? 'selected' : '' }}>نعم</option>
                                    <option value="0" {{ $patient->mother->family->has_rehabilitation_centers == false ? 'selected' : '' }}>لا</option>
                                </select>

                            </div>
                            <div id="has_rehabilitation_centers_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">عدد البالغين الأصحاء</label>
                            <div class="d-flex align-items-center">
                                <span id="healthy_adults_count_text" class="flex-grow-1">{{ $patient->mother->family->healthy_adults_count }}</span>
                                <input type="number" id="healthy_adults_count_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->family->healthy_adults_count }}">

                            </div>
                            <div id="healthy_adults_count_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">الدخل السنوي</label>
                            <div class="d-flex align-items-center">
                                <input type="number" id="annual_income_input" name="annual_income"
                                       class="form-control d-none flex-grow-1" value="{{ $patient->mother->family->annual_income }}">

                            </div>
                        </div>
                    </div>

                    {{-- تبويب الأم --}}
                    <div class="tab-pane fade" id="mother" role="tabpanel">
                        @php
                            $academic_levels = ['ابتدائي', 'إعدادي', 'ثانوي', 'دبلوم', 'بكالوريا', 'جامعي', 'دراسات عليا'];
                        @endphp

                        <div class="mb-4">
                            <label class="form-label">رقم الهوية</label>
                            <div class="d-flex align-items-center">
                                <span id="mother_national_id_text" class="flex-grow-1">{{ $patient->mother->national_id }}</span>
                                <input type="text" id="mother_national_id_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->national_id }}" maxlength="9" pattern="\d{9}" title="يجب أن يكون 9 أرقام فقط">

                            </div>
                            <div id="mother_national_id_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">الاسم</label>
                            <div class="d-flex align-items-center">
                                <span id="mother_name_text" class="flex-grow-1">{{ $patient->mother->name }}</span>
                                <input type="text" id="mother_name_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->name }}">

                            </div>
                            <div id="mother_name_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">تاريخ الميلاد</label>
                            <div class="d-flex align-items-center">
                                <span id="mother_birth_date_text" class="flex-grow-1">{{ $patient->mother->birth_date }}</span>
                                <input type="date" id="mother_birth_date_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->birth_date }}">
                            </div>
                            <div id="mother_birth_date_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">الحالة الصحية</label>
                            <div class="d-flex align-items-center">
                                <span id="mother_health_status_text" class="flex-grow-1">{{ $patient->mother->health_status }}</span>
                                <input type="text" id="mother_health_status_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->health_status }}">
                            </div>
                            <div id="mother_health_status_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">المستوى الأكاديمي</label>
                            <div class="d-flex align-items-center">
                                <span id="mother_academic_level_text" class="flex-grow-1">{{ $patient->mother->academic_level }}</span>
                                <select id="mother_academic_level_input" class="form-control d-none flex-grow-1">
                                    @foreach($academic_levels as $level)
                                        <option value="{{ $level }}" {{ $patient->mother->academic_level == $level ? 'selected' : '' }}>{{ $level }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div id="mother_academic_level_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">المهنة</label>
                            <div class="d-flex align-items-center">
                                <span id="mother_profession_text" class="flex-grow-1">{{ $patient->mother->profession }}</span>
                                <input type="text" id="mother_profession_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->profession }}">

                            </div>
                            <div id="mother_profession_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">عدد مرات الزواج</label>
                            <div class="d-flex align-items-center">
                                <span id="mother_marriages_count_text" class="flex-grow-1">{{ $patient->mother->marriages_count }}</span>
                                <input type="number" id="mother_marriages_count_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->marriages_count }}">

                            </div>
                            <div id="mother_marriages_count_error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">العلاقة مع الأب</label>
                            <div class="d-flex align-items-center">
                                <span id="mother_relationship_text" class="flex-grow-1">{{ $patient->mother->relationship_with_father }}</span>
                                <input type="text" id="mother_relationship_input" class="form-control d-none flex-grow-1" value="{{ $patient->mother->relationship_with_father }}">

                            </div>
                            <div id="mother_relationship_error" class="text-danger small mt-1"></div>
                        </div>

                        {{-- الأسئلة الخاصة بفترة الحمل --}}
                        @php
                            $pregnancy_questions = [
                                'had_diseases_during_pregnancy' => 'هل أصيبت بأمراض أثناء الحمل؟',
                                'had_accidents_during_pregnancy' => 'هل تعرضت لحوادث أثناء الحمل؟',
                                'smoked_during_pregnancy' => 'هل كانت تُدخن أثناء الحمل؟',
                                'visited_doctor_during_pregnancy' => 'هل زارت طبيب أثناء الحمل؟',
                            ];
                        @endphp

                        @foreach($pregnancy_questions as $field => $label)
                            <div class="mb-4">
                                <label class="form-label">{{ $label }}</label>
                                <div class="d-flex align-items-center">
                                    <span id="mother_{{ $field }}_text" class="flex-grow-1">{{ $patient->mother->$field ? 'نعم' : 'لا' }}</span>
                                    <select id="mother_{{ $field }}_input" class="form-control d-none flex-grow-1">
                                        <option value="1" {{ $patient->mother->$field == true ? 'selected' : '' }}>نعم</option>
                                        <option value="0" {{ $patient->mother->$field == false ? 'selected' : '' }}>لا</option>
                                    </select>

                                </div>
                                <div id="mother_{{ $field }}_error" class="text-danger small mt-1"></div>
                            </div>
                        @endforeach

                        <div class="mb-4">
                            <label class="form-label">هل لديها إعاقة؟</label>
                            <div class="d-flex align-items-center">
                                <span id="mother_has_disabilities_text" class="flex-grow-1">{{ $patient->mother->has_disabilities ? 'نعم' : 'لا' }}</span>
                                <select id="mother_has_disabilities_input" class="form-control d-none flex-grow-1">
                                    <option value="1" {{ $patient->mother->has_disabilities == true ? 'selected' : '' }}>نعم</option>
                                    <option value="0" {{ $patient->mother->has_disabilities == false ? 'selected' : '' }}>لا</option>
                                </select>

                            </div>
                            <div id="mother_has_disabilities_error" class="text-danger small mt-1"></div>
                        </div>
                    </div>
                    {{--effect--}}
                    <div class="tab-pane fade" id="effect" role="tabpanel">

                        @if ($patient->effect)
                            @php
                                $fields = [
                                    'health_physical' => 'الحالة الجسدية',
                                    'health_mental' => 'الحالة العقلية',
                                    'health_psychological' => 'الحالة النفسية',
                                    'education' => 'التعليم',
                                    'marital_life' => 'الحياة الزوجية',
                                    'social_activities' => 'الأنشطة الاجتماعية',
                                    'social_skills' => 'المهارات الاجتماعية',
                                    'self_management' => 'الاعتماد على النفس',
                                    'family_relationship' => 'العلاقة الأسرية',
                                    'work' => 'العمل',
                                    'financial_independence' => 'الاستقلال المالي',
                                    'public_life' => 'الحياة العامة',
                                ];
                            @endphp

                            @foreach ($fields as $name => $label)
                                <div class="mb-4">
                                    <label class="form-label">{{ $label }}</label>
                                    <div class="d-flex align-items-center">
                                        <span id="{{ $name }}_text" class="flex-grow-1">{{ optional($patient->effect)->{$name} ? $grades->firstWhere('id', $patient->effect->{$name})->name ?? '' : '' }}</span>
                                        <select id="{{ $name }}_input" name="{{ $name }}" class="form-control d-none flex-grow-1">
                                            @foreach ($grades as $grade)
                                                <option value="{{ $grade->id }}" {{ optional($patient->effect)->{$name} == $grade->id ? 'selected' : '' }}>
                                                    {{ $grade->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div id="{{ $name }}_error" class="text-danger small mt-1"></div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    {{--member--}}
                    <div class="tab-pane fade" id="family" role="tabpanel">

                        <h2>👨‍👩‍👧‍👦 أفراد العائلة</h2>
                        <table border="1" cellpadding="10" cellspacing="0">
                            <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>سنة الميلاد</th>
                                <th>العلاقة</th>
                                <th>الحالة الاجتماعية</th>
                                <th>المستوى الأكاديمي</th>
                                <th>الحالة الصحية</th>
                                <th>هل لديه إعاقة؟</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($members as $member)
                                <tr>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->birth_year }}</td>
                                    <td>{{ $member->relationship }}</td>
                                    <td>{{ $member->social_status }}</td>
                                    <td>{{ $member->academic_level }}</td>
                                    <td>{{ $member->health_status }}</td>
                                    <td>{{ $member->has_disability ? 'نعم' : 'لا' }}</td>
                                    <td>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">لا يوجد أفراد في هذه العائلة.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

@push('css')
    <link href="{{ asset('css/info1.css') }}" rel="stylesheet">
@endpush

@section('page')

    <div class="card">
        <div class="card-header ">
            <h4> معلومات خاصة بالمريض</h4>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif


            <form id="patient-form" action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Hidden IDs --}}
                <input type="hidden" name="mother_id" value="{{ $mother_id }}" data-required="true">
                @error('mother_id') <span class="text-danger">{{ $message }}</span> @enderror
                {{--                @error('family_id') <span class="text-danger">{{ $message }}</span> @enderror--}}

                {{-- الاسم --}}
                <div class="mb-3">
                    <label>الاسم:</label>
                    <input type="text"  name="name" value="{{ old('name') }}" required data-required="true">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- رقم الهوية --}}
                <div class="mb-3">
                    <label for="national_id" class="form-label" >رقم الهوية:</label>
                    <input type="text"
                           id="national_id"
                           name="national_id"
                           value="{{ old('national_id') }}"
                           required
                           minlength="9"
                           maxlength="9"
                           pattern="\d{9}"
                           title="يجب أن يكون 9 أرقام فقط"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,9)" data-required="true">
                    @error('national_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- تاريخ الميلاد --}}
                <div class="mb-3">
                    <label>تاريخ الميلاد:</label>
                    <div class="position-relative">
                        <input type="text" name="birth_date" class="form-control flatpickr-birth pe-5" value="{{ old('birth_date') }}" required data-required="true">
                        <i class="fa fa-calendar position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: #333;" id="calendar-birth-icon"></i>
                    </div>
                    @error('birth_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                {{-- نوع الإعاقة --}}
                <div class="mb-3">
                    <label class="form-label">نوع الإعاقة</label>
                    <select class="form-control" name="disability_type_id" required data-required="true">
                        <option value="" disabled {{ old('disability_type_id') ? '' : 'selected' }} hidden style="color: #aaa;">اختر..</option>
                        @foreach($disability_types as $disability_type)
                            <option value="{{ $disability_type->id }}" {{ old('disability_type_id') == $disability_type->id ? 'selected' : '' }}>
                                {{ $disability_type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- سبب الإعاقة --}}
                <div class="mb-3">
                    <label class="form-label">سبب الإعاقة</label>
                    <select class="form-control" name="disability_cause_id" required data-required="true">
                        <option value="" disabled {{ old('disability_cause_id') ? '' : 'selected' }} hidden style="color: #aaa;">اختر..</option>
                        @foreach($disability_causes as $disability_cause)
                            <option value="{{ $disability_cause->id }}" {{ old('disability_cause_id') == $disability_cause->id ? 'selected' : '' }}>
                                {{ $disability_cause->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- تاريخ الإصابة --}}
                <div class="mb-3">
                    <label>تاريخ الإصابة:</label>
                    <div class="position-relative">
                        <input type="text" name="injury_date" class="form-control flatpickr-injury pe-5" value="{{ old('injury_date', $patient->injury_date ?? '') }}" required data-required="true">
                        <i class="fa fa-calendar position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: #333;" id="calendar-injury-icon"></i>
                    </div>
                    @error('injury_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- دورات المياه --}}
                <div class="mb-3">
                    <label>دورات المياه:</label>
                    <select name="toilet_facilities" required class="form-control" data-required="true">
                        <option value="" disabled {{ old('toilet_facilities') ? '' : 'selected' }} hidden style="color: #aaa;">اختر..</option>
                        <option value="خارجي" {{ old('toilet_facilities') == 'خارجي' ? 'selected' : '' }}>خارجي</option>
                        <option value="داخلي" {{ old('toilet_facilities') == 'داخلي' ? 'selected' : '' }}>داخلي</option>
                    </select>
                    @error('toilet_facilities') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>


                {{-- مصدر المياه --}}
                <div class=" mb-3">
                    <label>مصدر المياه:</label>
                    <input type="text" name="water_source" value="{{ old('water_source') }}" required data-required="true">
                    @error('water_source') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- مصدر الكهرباء --}}
                <div class="mb-3">
                    <label>مصدر الكهرباء:</label>
                    <input type="text" name="electricity_source" value="{{ old('electricity_source') }}" required data-required="true">
                    @error('electricity_source') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- الدخل الشهري --}}
                <div class="mb-3">
                    <label>الدخل الشهري:</label>
                    <input type="number" name="monthly_income" value="{{ old('monthly_income') }}" required data-required="true">
                    @error('monthly_income') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- ترتيب في الأسرة --}}
                <div class=" mb-3">
                    <label>الترتيب في الأسرة:</label>
                    <input type="number" name="family_order" value="{{ old('family_order') }}" required data-required="true">
                    @error('family_order') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- العلاقة برب الأسرة --}}
                <div class="mb-3">
                    <label>العلاقة برب الأسرة:</label>
                    <input type="text" name="relationship_to_head" value="{{ old('relationship_to_head') }}" required data-required="true">
                    @error('relationship_to_head') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                <div class="mb-3">
                    <label>الحالة الاجتماعية:</label>
                    <select name="social_status" id="social_status" class="form-control" required data-required="true">
                        <option value="" disabled selected hidden style="color: #aaa;">اختر الحالة الاجتماعية</option>
                        <option value="أعزب" {{ old('social_status', $patient->social_status ?? '') == 'أعزب' ? 'selected' : '' }}>أعزب</option>
                        <option value="متزوج" {{ old('social_status', $patient->social_status ?? '') == 'متزوج' ? 'selected' : '' }}>متزوج</option>
                        <option value="مطلق" {{ old('social_status', $patient->social_status ?? '') == 'مطلق' ? 'selected' : '' }}>مطلق</option>
                        <option value="أرمل" {{ old('social_status', $patient->social_status ?? '') == 'أرمل' ? 'selected' : '' }}>أرمل</option>
                    </select>
                    @error('social_status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- مكان إقامة المعاق --}}
                <div class="mb-3">
                    <label>مكان الإقامة:</label>
                    <select name="disabled_person_residence" required class="form-control" data-required="true">
                        <option value="" disabled {{ old('disabled_person_residence') ? '' : 'selected' }} hidden style="color: #aaa;">اختر..</option>
                        <option value="داخل الأسرة" {{ old('disabled_person_residence') == 'داخل الأسرة' ? 'selected' : '' }}>داخل الأسرة</option>
                        <option value="داخل مؤسسة" {{ old('disabled_person_residence') == 'داخل مؤسسة' ? 'selected' : '' }}>داخل مؤسسة</option>
                        <option value="عند الأقارب" {{ old('disabled_person_residence') == 'عند الأقارب' ? 'selected' : '' }}>عند الأقارب</option>
                    </select>
                    @error('disabled_person_residence') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- مستوى الاعتماد على النفس --}}
                <div class="mb-3">
                    <label>مستوى الاعتماد على النفس:</label>
                    <input type="text" name="self_dependence_level" value="{{ old('self_dependence_level') }}" required data-required="true">
                    @error('self_dependence_level') <span class="text-danger">{{ $message }}</span> @enderror
                </div>



                {{-- الهاتف --}}
                <div class="mb-3">
                    <label>رقم الهاتف:</label>
                    <input type="text" name="phone_number"  placeholder="مثال: 05XXXXXXXX" value="{{ old('phone_number') }}">
                    @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

{{--                --}}{{-- الفاكس --}}
{{--                <div class="mb-3">--}}
{{--                    <label>رقم الفاكس:</label>--}}
{{--                    <input type="text"--}}
{{--                           name="fax_number"--}}
{{--                           value="{{ old('fax_number') }}">--}}
{{--                    @error('fax_number') <span class="text-danger">{{ $message }}</span> @enderror--}}
{{--                </div>--}}




                {{-- الحالة الوظيفية --}}
                <div class="mb-3">
                    <label>الحالة الوظيفية:</label>
                    <select name="employment_status" id="employment_status" required data-required="true">
                        <option value="" disabled selected hidden style="color: #aaa;">اختر..  </option>
                        <option value="يعمل">يعمل</option>
                        <option value="لا يعمل">لا يعمل</option>
                    </select>
                    @error('employment_status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                {{-- التوظيف --}}
                <div id="employment_fields_group" style="display: none;">
                    <div class="mb-3 ps-4" id="employment_details" >

                        <label  id="employment_type_label">نوع التوظيف:</label>
                        <select name="employment_type">
                            <option value="" disabled selected hidden style="color: #aaa;">اختر..  </option>
                            <option value="جزئي">جزئي</option>
                            <option value="كلي">كلي</option>
                        </select>
                        @error('employment_type') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3 ps-4">
                        <label id="job_type_label" >نوع الوظيفة:</label>
                        <input type="text" name="job_type" value="{{ old('job_type') }}">
                        @error('job_type') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3 ps-4">
                        <label  id="employment_method_label" >طريقة التوظيف:</label>
                        <input type="text" name="employment_method" value="{{ old('employment_method') }}">
                        @error('employment_method') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- هل يتعلم؟ --}}
                <div class="mb-3">
                    <div class="form-check">
                        <input type="hidden" name="education_status" value="0">
                        <input class="form-check-input" type="checkbox" id="education_status" name="education_status" value="1"
                            {{ old('education_status', isset($patient) ? $patient->education_status : false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="education_status">هل يتعلم؟</label>
                    </div>
                </div>

                {{-- نوع التعليم --}}
                <div class="mb-3 ps-4" id="education_type_wrapper">
                    <label id="education_type_label" >نوع التعليم:</label>
                    <select name="education_type">
                        <option value="" disabled selected hidden style="color: #aaa;">اختر..  </option>
                        <option value="مركز تربية خاصة">مركز تربية خاصة</option>
                        <option value="مدرسة عامة">مدرسة عامة</option>
                        <option value="جامعة">جامعة</option>
                    </select>
                    @error('education_type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                {{-- سبب عدم التعليم --}}
                <div class="mb-3 ps-4">
                    <label>سبب عدم التعليم:</label>
                    <input type="text" name="education_reason" value="{{ old('education_reason') }}">
                    @error('education_reason') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                {{-- تدريب مهني --}}
                <div class="mb-3">
                    <div class="form-check">
                        <input type="hidden" name="vocational_training" value="0">
                        <input class="form-check-input" type="checkbox" id="vocational_training" name="vocational_training" value="1"
                            {{ old('vocational_training', isset($patient) ? $patient->vocational_training : false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="vocational_training">تدريب مهني</label>
                    </div>
                    @error('vocational_training')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- مكان التدريب --}}
                <div id="vocational_training_fields" style="display: none;">
                    <div class="mb-3 ps-4">
                        <label id="training_location_label" >مكان التدريب:</label>
                        <input type="text" name="training_location" value="{{ old('training_location') }}">
                        @error('training_location') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- نوع التدريب --}}
                    <div class="mb-3 ps-4">
                        <label id="training_type_label" >نوع التدريب:</label>
                        <input type="text" name="training_type" value="{{ old('training_type') }}">
                        @error('training_type') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>


                {{-- الشؤون الاجتماعية تتابع الحالة --}}
                <div class="mb-3">
                    <div class="form-check">
                        <input type="hidden" name="social_case_responsible" value="0">
                        <input class="form-check-input" type="checkbox" id="social_case_responsible" name="social_case_responsible" value="1"
                            {{ old('social_case_responsible', isset($patient) ? $patient->social_case_responsible : false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="social_case_responsible">الشؤون الاجتماعية تتابع الحالة؟</label>
                    </div>
                </div>

                {{-- صلة مسؤول الشؤون --}}
                <div class="mb-3 ps-4" id="relation_field">
                    <label id="relation_label" for="social_case_responsible_relation">صلة مسؤول الشؤون:</label>
                    <input type="text" id="social_case_responsible_relation" name="social_case_responsible_relation" class="form-control"
                           value="{{ old('social_case_responsible_relation') }}">
                    @error('social_case_responsible_relation')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- اتحاد المعاقين يتابع الحالة --}}
                <div class="mb-3">
                    <div class="form-check">
                        <input type="hidden" name="disability_union_responsible" value="0">
                        <input class="form-check-input" type="checkbox" id="disability_union_responsible" name="disability_union_responsible" value="1"
                            {{ old('disability_union_responsible', isset($patient) ? $patient->disability_union_responsible : false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="disability_union_responsible">اتحاد المعاقين يتابع الحالة؟</label>
                    </div>
                </div>

                {{-- نسبة العجز --}}
                <div class="mb-3 ps-4 "  id="disability_percentage_field" >
                    <label id="disability_percentage_label" >نسبة العجز الدائم:</label>
                    <input type="number" name="permanent_disability_percentage" value="{{ old('permanent_disability_percentage') }}" >
                    @error('permanent_disability_percentage') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- هل هو لاجئ؟ --}}
                <div class="mb-3">
                    <div class="form-check">
                        <input type="hidden" name="refugee_status" value="0">
                        <input class="form-check-input" type="checkbox" id="refugee_status" name="refugee_status" value="1"
                            {{ old('refugee_status', isset($patient) ? $patient->refugee_status : false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="refugee_status">هل هو لاجئ؟</label>
                    </div>
                </div>

                {{-- رقم بطاقة الأونروا --}}
                <div class="mb-3 ps-4"  id="unwra_card_field" >
                    <label id="unwra_card_label" >رقم بطاقة الأونروا:</label>
                    <input type="text" name="unwra_card_number"
                           value="{{ old('unwra_card_number') }}"
                           minlength="8"
                           maxlength="8"
                           pattern="\d{8}"
                           title="يجب أن يكون 8 أرقام فقط">
                    @error('unwra_card_number') <span class="text-danger">{{ $message }}</span> @enderror
                </div>




                {{--        <div class="mb-4">--}}
                {{--            <label for="medical_report_file" class="block text-gray-700 font-bold mb-2">--}}
                {{--                التقرير الطبي--}}
                {{--            </label>--}}
                {{--            <input--}}
                {{--                type="file"--}}
                {{--                name="medical_report_file"--}}
                {{--                id="medical_report_file"--}}
                {{--                accept=".jpg, .jpeg, .png, .pdf"--}}
                {{--                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('medical_report_file') border-red-500 @enderror"--}}

                {{--            >--}}
                {{--            <p class="mt-1 text-sm text-gray-500">الملفات المسموحة: PDF, JPG, JPEG, PNG (بحد أقصى 2 ميغابايت)</p>--}}

                {{--            @error('medical_report_file')--}}
                {{--            <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>--}}
                {{--            @enderror--}}
                {{--        </div>--}}


                <button type="submit" id="submitPatient" class="btn btn-success">حفظ</button>
            </form>
        </div>


@endsection

@push('js')
    <script src= "{{ asset('js/info1.js') }}"> </script>
@endpush


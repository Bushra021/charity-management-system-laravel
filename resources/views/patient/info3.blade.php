@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

@push('css')
    <link rel="stylesheet" href="{{ asset('/css/info3.css') }}">
@endpush

@section('page')

    <div class="container">
        <h2 class="mb-4">تعبئة بيانات الأب</h2>


        <form id="patient-form" method="POST" action="{{ route('families.store') }}">
            @csrf
            <!-- هوية الأب -->
            <div class="mb-3">
                <label for="national_id" class="form-label">رقم هوية الأب</label>
                <input type="text"
                       id="national_id"
                       name="national_id"
                       class="form-control"
                       value="{{ old('national_id') }}"
                       required
                       minlength="9"
                       maxlength="9"
                       pattern="\d{9}"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,9)">
                @error('national_id')
                <div class="text-success">{{ $message }}</div>
                @enderror

            </div>

            @php
                $showFatherInfo = old('name') || $errors->has('name') || $errors->has('birth_date') || $errors->has('health_status') || $errors->has('academic_level');
            @endphp

            <div id="father-info" class="border p-3 mb-4" style="{{ $showFatherInfo ? '' : 'display:none;' }}">

                {{--           <div id="father-info" class="border p-3 mb-4" style="display:none;">--}}
                <h5>بيانات الأب</h5>
                <div class="form-group">
                    <label for="name"> الاسم :</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required maxlength="100">
                    @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                {{-- تاريخ الميلاد --}}
                <div class="form-group">
                    <label>تاريخ الميلاد :</label>
                    <div class="position-relative">
                        <input type="text" name="birth_date" class="form-control flatpickr-birth pe-5 w-100" ...>
                        <i class="fa fa-calendar position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: #333;" id="calendar-birth-icon"></i>
                    </div>
                    @error('birth_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                <div class="form-group">
                    <label for="health_status">الحالة الصحية :</label>
                    <textarea name="health_status" id="health_status" class="form-control" required>{{ old('health_status') }}</textarea>
                    @error('health_status')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>رقم الهاتف :</label>
                    <input type="text" name="phone" class="form-control"  placeholder="مثال: 05XXXXXXXX" value="{{ old('phone') }}">
                    @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="academic_level">المستوى الأكاديمي :</label>
                    <select name="academic_level" id="academic_level" class="form-control large-option" required>
                        <option value="" disabled selected hidden style="color: #aaa;">اختر..  </option>
                        <option value="ابتدائي" {{ old('academic_level') == 'ابتدائي' ? 'selected' : '' }}>ابتدائي</option>
                        <option value="إعدادي" {{ old('academic_level') == 'إعدادي' ? 'selected' : '' }}>إعدادي</option>
                        <option value="ثانوي" {{ old('academic_level') == 'ثانوي' ? 'selected' : '' }}>ثانوي</option>
                        <option value="دبلوم" {{ old('academic_level') == 'دبلوم' ? 'selected' : '' }}>دبلوم</option>
                        <option value="بكالوريا" {{ old('academic_level') == 'بكالوريا' ? 'selected' : '' }}>بكالوريا</option>
                        <option value="جامعي" {{ old('academic_level') == 'جامعي' ? 'selected' : '' }}>جامعي</option>
                        <option value="دراسات عليا" {{ old('academic_level') == 'دراسات عليا' ? 'selected' : '' }}>دراسات عليا</option>
                    </select>
                    @error('academic_level')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="profession">المهنة :</label>
                    <input type="text" name="profession" id="profession" class="form-control" value="{{ old('profession') }}" maxlength="100">
                    @error('profession')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="marriages_count"> عدد مرات الزواج :</label>
                    <input type="number" name="marriages_count" id="marriages_count" class="form-control" value="{{ old('marriages_count', 1) }}" min="0">
                    @error('marriages_count')<div class="text-danger">{{ $message }}</div>@enderror
                </div>


                <div class="form-group">
                    <label for="family_type">نوع العائلة :</label>
                    <select name="family_type" id="family_type" class="form-control large-option" required>
                        <option value="" disabled selected hidden style="color: #aaa;">اختر..  </option>
                        <option value="ممتدة" {{ old('family_type') == 'ممتدة' ? 'selected' : '' }}>ممتدة</option>
                        <option value="نووية" {{ old('family_type') == 'نووية' ? 'selected' : '' }}>نووية</option>
                    </select>
                    @error('family_type')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="healthy_adults_count">عدد البالغين الأصحاء :</label>
                    <input type="number" name="healthy_adults_count" id="healthy_adults_count" class="form-control" value="{{ old('healthy_adults_count', 1) }}" min="0">
                    @error('healthy_adults_count')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="annual_income">الدخل السنوي :</label>
                    <input type="number" step="0.01" name="annual_income" id="annual_income" class="form-control" value="{{ old('annual_income') }}">
                    @error('annual_income')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="house_ownership">نوع الملكية :</label>
                    <select name="house_ownership" id="house_ownership" class="form-control large-option" required>
                        <option value="" disabled selected hidden style="color: #aaa;">اختر..  </option>
                        <option value="ملك" {{ old('house_ownership') == 'ملك' ? 'selected' : '' }}>ملك</option>
                        <option value="إيجار" {{ old('house_ownership') == 'إيجار' ? 'selected' : '' }}>إيجار</option>
                    </select>
                    @error('house_ownership')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group" id="monthly_rent_group" style="display: none;">
                    <label for="monthly_rent">الإيجار الشهري :</label>
                    <input type="number" step="0.01" name="monthly_rent" id="monthly_rent" class="form-control" value="{{ old('monthly_rent') }}">
                    @error('monthly_rent')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="room_count">عدد الغرف في المنزل :</label>
                    <input type="number" name="room_count" id="room_count" class="form-control" value="{{ old('room_count', 1) }}" min="0">
                    @error('room_count')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="has_health_insurance">هل يوجد تأمين صحي؟</label>
                    <input type="checkbox" name="has_health_insurance" id="has_health_insurance" value="0" {{ old('has_health_insurance', true) ? 'checked' : '' }}>
                    @error('has_health_insurance')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group" id="health_insurance_reason_group" style="display: none;">
                    <label for="health_insurance_reason">ما سبب  عدم وجود تأمين الصحي ؟</label>
                    <input type="text" name="health_insurance_reason" id="health_insurance_reason" class="form-control" value="{{ old('health_insurance_reason') }}" maxlength="255">
                    @error('health_insurance_reason')<div class="text-danger">{{ $message }}</div>@enderror
                </div>


                <div class="form-group">
                    <label for="has_disabilities">هل يوجد إعاقات لدى الأب؟</label>
                    <input type="checkbox" name="has_disabilities" id="has_disabilities" value="1" {{ old('has_disabilities') ? 'checked' : '' }}>
                    @error('has_disabilities')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="disability_family">هل يوجد إعاقات في عائلة الأب؟</label>
                    <input type="checkbox" name="disability_family" id="disability_family" value="1" {{ old('disability_family') ? 'checked' : '' }}>
                    @error('disability_family')<div class="text-danger">{{ $message }}</div>@enderror
                </div>


                <div class="form-group">
                    <label for="has_rehabilitation_centers">هل يوجد مراكز تأهيل في منطقنكم؟</label>
                    <input type="checkbox" name="has_rehabilitation_centers" id="has_rehabilitation_centers" value="1" {{ old('has_rehabilitation_centers') ? 'checked' : '' }}>
                    @error('has_rehabilitation_centers')<div class="text-danger">{{ $message }}</div>@enderror
                </div>


                <button type="submit" class="btn btn-primary mt-3">تسجيل</button>
            </div>
        </form>
    </div>

@endsection

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'نجاح',
            text: '{{ session('success') }}',
            confirmButtonText: 'حسنًا'
        });
    </script>
@endif

@push('js')
    <script src= "{{ asset('js/info3.js') }}"> </script>
@endpush

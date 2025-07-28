@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">
@push('css')
    <link href="{{ asset('css/info2.css') }}" rel="stylesheet">
@endpush

@section('page')
    <div class="container">
        <h2 class="mb-4">تعبئة بيانات الأم </h2>

        <form id="mother-form" method="POST" action="{{ route('mothers.store') }}">
            @csrf
            <!-- هوية الأم -->
            <div class="mb-3">
                <label for="national_id" class="form-label">رقم هوية الأم</label>
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
                @error('national_id')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            @php
                $showMotherInfo = count($errors) > 0 || old('name');
            @endphp

            <div id="mother-info" class="border p-3 mb-4" style="{{ $showMotherInfo ? '' : 'display:none;' }}">

                <h5>بيانات الأم</h5>

                {{-- Hidden Family ID --}}
                <input type="hidden" name="family_id" value="{{ $familyId }}">
                {{-- الاسم --}}
                <div class="form-group">
                    <label for="name">الاسم :</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required maxlength="100">
                    @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                {{-- تاريخ الميلاد --}}
                <div class="form-group">
                    <label>تاريخ الميلاد :</label>
                    <div class="position-relative">
                        <input type="text" name="birth_date" id="birth_date" class="form-control flatpickr-birth pe-5 w-100" value="{{ old('birth_date') }}">
                        <i class="fa fa-calendar position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: #333;" id="calendar-birth-icon"></i>
                    </div>
                    @error('birth_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="health_status" >الحالة الصحية :</label>
                    <textarea name="health_status" id="health_status" class="form-control @error('health_status') is-invalid @enderror" required>{{ old('health_status') }}</textarea>
                    @error('health_status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                {{-- المستوى الأكاديمي --}}
                <div class="form-group">
                    <label for="academic_level">المستوى الأكاديمي :</label>
                    <select name="academic_level" id="academic_level" class="form-control @error('academic_level') is-invalid @enderror" required>
                        <option value=""> اختر </option>
                        @foreach(['ابتدائي','إعدادي','ثانوي','دبلوم','بكالوريا','جامعي','دراسات عليا'] as $level)
                            <option value="{{ $level }}" {{ old('academic_level') == $level ? 'selected' : '' }}>{{ $level }}</option>
                        @endforeach
                    </select>
                    @error('academic_level')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                {{-- المهنة --}}
                <div class="form-group">
                    <label for="profession">المهنة :</label>
                    <input type="text" name="profession" id="profession" class="form-control @error('profession') is-invalid @enderror" value="{{ old('profession') }}" maxlength="100">
                    @error('profession')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="marriages_count">عدد مرات الزواج :</label>
                    <input type="number" name="marriages_count" id="marriages_count" class="form-control @error('marriages_count') is-invalid @enderror" value="{{ old('marriages_count', 1) }}" min="0">
                    @error('marriages_count')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                {{-- العلاقة مع الأب --}}
                <div class="form-group">
                    <label for="relationship_with_father">العلاقة مع الأب</label>
                    <input type="text" name="relationship_with_father" id="relationship_with_father" class="form-control @error('relationship_with_father') is-invalid @enderror" value="{{ old('relationship_with_father') }}" required maxlength="50">
                    @error('relationship_with_father')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>


                <div class="form-check">
                    <input type="checkbox" name="has_disabilities" id="has_disabilities" value="1" class="form-check-input" {{ old('has_disabilities') ? 'checked' : '' }}>
                    <label class="form-check-label" for="has_disabilities">هل يوجد إعاقات في عائلة الأم؟</label>
                </div>

                <div class="form-check">
                    <input type="checkbox" name="had_diseases_during_pregnancy" id="had_diseases_during_pregnancy" class="form-check-input" value="1" {{ old('had_diseases_during_pregnancy') ? 'checked' : '' }}>
                    <label class="form-check-label" for="had_diseases_during_pregnancy">هل عانت من أمراض خلال الحمل؟</label>
                </div>


                <div class="form-check">
                    <input type="checkbox" name="had_accidents_during_pregnancy" id="had_accidents_during_pregnancy" class="form-check-input" value="1" {{ old('had_accidents_during_pregnancy') ? 'checked' : '' }}>
                    <label class="form-check-label" for="had_accidents_during_pregnancy">هل تعرضت لحوادث خلال الحمل؟</label>
                </div>

                <div class="form-check">
                    <input type="checkbox" name="smoked_during_pregnancy" id="smoked_during_pregnancy" class="form-check-input" value="1" {{ old('smoked_during_pregnancy') ? 'checked' : '' }}>
                    <label class="form-check-label" for="smoked_during_pregnancy">هل دخنت خلال الحمل؟</label>
                </div>

                <div class="form-check">
                    <input type="checkbox" name="visited_doctor_during_pregnancy" id="mother_visited_doctor_during_pregnancy" class="form-check-input" value="1" {{ old('visited_doctor_during_pregnancy') ? 'checked' : '' }}>
                    <label class="form-check-label" for="visited_doctor_during_pregnancy">هل زارت الطبيب خلال الحمل؟</label>
                </div>


                <button type="submit" class="btn btn-primary mt-3">تسجيل</button>
            </div>

        </form>
    </div>

@endsection


@push('js')
    <script src= "{{ asset('js/info2.js') }}"> </script>
@endpush

@extends('layouts.master')


@push('css')
    <link href="{{ asset('css/effect.css') }}" rel="stylesheet">
@endpush
@section('page')
    <div class="container">
        <h2 class="mb-4">  تسجيل تأثير الإعاقة على حياة المريض</h2>

        {{-- رسالة النجاح --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }} </div>
        @endif

        {{-- رسالة الخطأ العامة --}}
        @if($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif


        <form action="{{ route('effect.store') }}" method="POST">
            @csrf

            @php
                $fields = [
                    'health_physical' => 'الصحة الجسدية',
                    'health_mental' => 'الصحة العقلية',
                    'health_psychological' => 'الصحة النفسية',
                    'education' => 'التعليم',
                    'marital_life' => 'الحياة الزوجية',
                    'social_activities' => 'الأنشطة الاجتماعية',
                    'social_skills' => 'المهارات الاجتماعية',
                    'self_management' => 'الإدارة الذاتية',
                    'family_relationship' => 'العلاقات العائلية',
                    'work' => 'العمل',
                    'financial_independence' => 'الاستقلال المالي',
                    'public_life' => 'الحياة العامة',
                ];
            @endphp

            @foreach($fields as $name => $label)
                <div class="mb-3">
                    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
                    <select name="{{ $name }}" id="{{ $name }}" class="form-select @error($name) is-invalid @enderror">
                        <option value="">اختر تقييم</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ old($name) == $grade->id ? 'selected' : '' }}>
                                {{ $grade->name }}
                            </option>
                        @endforeach
                    </select>
                    @error($name)
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
    </div>
@endsection


@push('js')
    <script src= "{{ asset('js/effect.js') }}"> </script>

@endpush

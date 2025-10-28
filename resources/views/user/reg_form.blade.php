@extends('layouts.master')

@push('css')
    <link href="{{ asset('/css/reg.css') }}" rel="stylesheet">
@endpush

@section('title', 'إنشاء حساب جديد')

@section('page')
    <div id="master">

        {{-- الشعار واسم الجمعية --}}
        <div class="logo-header">
            <img src="{{ asset('../images/logo.jpg') }}" alt="شعار الجمعية" class="logo-img">
            <span class="association-name">جمعية الرحمة الخيرية للتأهيل</span>
        </div>

        {{-- عنوان الترحيب --}}
        <div class="form-wrapper">
            <h2 class="form-heading">أهلاً وسهلاً! أنشئ حسابك الآن</h2>
        </div>

        {{-- نموذج التسجيل --}}
        <form action="{{ route('register') }}" method="post" enctype="multipart/form-data">
            @csrf

            {{-- الاسم --}}
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="الاسم">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror

            {{-- اسم المستخدم --}}
            <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="البريد الإلكتروني ">
            @error('username')
            <span class="text-danger">{{ $message }}</span>
            @enderror

            {{-- رقم الهوية --}}
            <input type="text" class="form-control" name="id_number" value="{{ old('id_number') }}" placeholder="رقم الهوية (اختياري)">
            @error('id_number')
            <span class="text-danger">{{ $message }}</span>
            @enderror

            {{-- كلمة المرور --}}
            <input type="password" class="form-control" name="password" placeholder="كلمة المرور">
            @error('password')
            <span class="text-danger">{{ $message }}</span>
            @enderror

            {{-- الجنس --}}
            <select name="gender" class="form-select mb-3">
                <option value="ذكر" {{ old('gender') == 'ذكر' ? 'selected' : '' }}>ذكر</option>
                <option value="أنثى" {{ old('gender') == 'أنثى' ? 'selected' : '' }}>أنثى</option>
            </select>

            {{-- المنطقة --}}
            <select name="area_id" class="form-select mb-3">
                <option value="">اختر المنطقة</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>

            {{-- الصورة الشخصية --}}
            <div class="mb-3">
                <label for="profile_picture" class="form-label">الصورة الشخصية:</label>
                <input type="file" name="profile_picture" id="profile_picture" class="form-control" accept="image/*">
                @error('profile_picture')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- زر الإرسال --}}
            <input type="submit" class="btn btn-primary" value="إنشاء حساب">

            {{-- روابط أسفل النموذج --}}
            <div class="form-footer mt-3">
                <div class="links">
                    <a href="{{ route('log_form') }}">تسجيل الدخول</a>
                    <span class="divider">|</span>
                    <a href="{{ url('/') }}">العودة للصفحة الرئيسية</a>
                </div>
            </div>

        </form>
    </div>
@endsection

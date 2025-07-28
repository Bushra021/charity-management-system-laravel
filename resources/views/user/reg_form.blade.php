@extends('layouts.master')

@push('css')
    <link href="{{ asset('/css/reg.css') }}" rel="stylesheet">
@endpush

@section('title', ' إنشاء حساب جديد')

@section('page')
    <div id="master">

        {{-- ✅ الشعار واسم الجمعية --}}
        <div class="logo-header">
            <img src="{{ asset('../images/logo.jpg') }}" alt="شعار الجمعية" class="logo-img">
            <span class="association-name">جمعية الرحمة الخيرية للتأهيل</span>
        </div>

        {{-- ✅ عنوان الترحيب --}}
        <div class="form-wrapper">
            <h2 class="form-heading">أهلاً وسهلاً! أنشئ حسابك الآن</h2>
        </div>

        {{-- ✅ نموذج التسجيل --}}
        <form action="{{ route("register") }}" method="post" enctype="multipart/form-data">
            @csrf

            {{-- ✅ الاسم --}}
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="الاسم">
            @error('name')
            <span>{{ $message }}</span>
            @enderror

            {{-- ✅ اسم المستخدم --}}
            <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="اسم المستخدم">
            @error('username')
            <span>{{ $message }}</span>
            @enderror

            {{-- ✅ كلمة المرور --}}
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="كلمة المرور">
            @error('password')
            <span>{{ $message }}</span>
            @enderror

            {{-- ✅ الجنس --}}
            <select name="gender" class="form-select">
                <option value="ذكر" {{ old('gender') == 'ذكر' ? 'selected' : '' }}>ذكر</option>
                <option value="أنثى" {{ old('gender') == 'أنثى' ? 'selected' : '' }}>أنثى</option>
            </select>


            {{-- ✅ المنطقة --}}
            <select name="area_id" class="form-select">
                @foreach($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
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

            <input type="submit" class="btn btn-primary" value="إنشاء حساب">
            {{-- ✅ زر الإرسال والروابط --}}
        </form>


            <div class="form-footer">
                <div class="links">
                    <a href="{{ route('log_form') }}">تسجيل الدخول</a>
                    <span class="divider">|</span>
                    <a href="{{ url('/') }}">العودة للصفحة الرئيسية</a>
                </div>
            </div>

            {{-- ✅ روابط تغيير اللغة --}}
            <div class="language-switch">
                <a href="/locale/ar">العربية</a>
                <span class="divider">|</span>
                <a href="/locale/en">English</a>
            </div>
    </div>
@endsection

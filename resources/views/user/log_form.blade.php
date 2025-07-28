@extends('layouts.master')

@push('css')
    <link href="{{ asset('/css/log.css') }}" rel="stylesheet">
@endpush

@section('title', ' تسجيل الدخول')

@section('page')

    <div id="master">


        <div class="logo-header">
            <img src="{{ asset('../images/logo.jpg') }}" alt="شعار الجمعية" class="logo-img">
            <span class="association-name">جمعية الرحمة الخيرية للتأهيل</span>

        </div>
        <div class="form-heading">
            <h2 class="form-heading"> أهلاً بعودتك،سجل دخولك للمتابعة</h2>
        </div>


        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="{{ __('strings.username') }}">
            @error('username')
            <span style="color:red">{{ $message }}</span>
            @enderror

            <input type="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="{{ __('strings.password') }}">
            @error('password')
            <span style="color:red">{{ $message }}</span>
            @enderror

            <input type="submit" class="btn btn-primary" value="تسجيل الدخول">

            @error('خطأ')
            <span style="color:red">{{ $message }}</span>
            @enderror

            <div class="links">
                <a href="{{ route('reg_form') }}">إنشاء حساب جديد</a>
                <span style="color: black;">|</span>
                <a href="{{ url('/') }}">العودة للصفحة الرئيسية</a>

                <a href="{{ route('password.request') }}">هل نسيت كلمة المرور؟</a>

            </div>


            <!-- روابط اللغة -->
            <div class="language-switch">
                <a href="/locale/ar">العربية</a>
                <span class="divider">|</span>
                <a href="/locale/en">English</a>
            </div>

        </form>
    </div>
@endsection

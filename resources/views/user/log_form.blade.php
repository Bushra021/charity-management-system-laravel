@extends('layouts.master')

@push('css')
    <link href="{{ asset('/css/log.css') }}" rel="stylesheet">
@endpush

@section('title', 'تسجيل الدخول')

@section('page')
    <div id="master">

        {{-- ✅ الشعار --}}
        <div class="logo-header">
            <img src="{{ asset('../images/logo.jpg') }}" alt="شعار الجمعية" class="logo-img">
            <span class="association-name">جمعية الرحمة الخيرية للتأهيل</span>
        </div>

        {{-- ✅ العنوان --}}
        <div class="form-heading">
            <h2>أهلاً بعودتك، سجل دخولك للمتابعة</h2>
        </div>

        {{-- ✅ نموذج تسجيل الدخول --}}
        <form action="{{ route('login') }}" method="POST">
            @csrf

            {{-- ✅ حقل البريد الإلكتروني أو رقم الهوية --}}
            <input type="text" name="username" class="form-control"
                   value="{{ old('username') }}"
                   placeholder="البريد الإلكتروني أو رقم الهوية">
            @error('username')
            <span style="color:red">{{ $message }}</span>
            @enderror

            {{-- ✅ كلمة المرور --}}
            <input type="password" name="password" class="form-control"
                   placeholder="كلمة المرور">
            @error('password')
            <span style="color:red">{{ $message }}</span>
            @enderror

            {{-- ✅ رسالة خطأ عامة --}}
            @error('login')
            <span style="color:red">{{ $message }}</span>
            @enderror

            {{-- ✅ زر الدخول --}}
            <input type="submit" class="btn btn-primary" value="تسجيل الدخول">

            {{-- ✅ الروابط الإضافية --}}
            <div class="links">
                <a href="{{ route('reg_form') }}">إنشاء حساب جديد</a>
                <span style="color: black;">|</span>
                <a href="{{ url('/') }}">العودة للصفحة الرئيسية</a>
                <span style="color: black;">|</span>
                <a href="{{ route('password.request') }}">هل نسيت كلمة المرور؟</a>
            </div>

            {{-- ✅ روابط تغيير اللغة --}}
            <div class="language-switch">
                <a href="/locale/ar">العربية</a>
                <span class="divider">|</span>
                <a href="/locale/en">English</a>
            </div>
        </form>
    </div>
@endsection


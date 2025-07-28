@extends('layouts.master')
@section('page')


    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <div class="dashboard-container">
        <div class="sidebar">
            <h3>لوحة التحكم</h3>



            <a href="{{route('appointment.index')}}">المواعيد</a><br>
            <a href="{{route('search-patient')}}"> الملاحظات </a><br>
            <a href="{{route('employee.service')}}">الخدمات المطلوبة </a><br>
            <a href="{{route('employee.service done')}}">الخدمات الجارية والمنهية </a><br>
            <a href="{{route('profile.show')}}">معلومات الحساب</a>



        </div>

        <div class="main-content">
            <div class="header">
                <div class="user-name">مرحباً، {{ auth()->user()->name }}</div>

                <img src="{{ asset('storage/' . (Auth::user()->profile_picture ?? 'defaults/profile.jpg')) }}" width="150" alt="الصورة الشخصية">

                <div class="logout-btn">
                    <a href="{{ route('logout') }}">تسجيل الخروج</a>
                </div>
            </div>

            <div class="welcome-message" style="text-align: center; padding: 40px;">
                <i class="fa-solid fa-stethoscope fa-3x" style="color: #e74c3c;"></i>
                <h2>مرحباً بك في النظام الطبي</h2>
                <p>أنت الآن في واجهتك الطبية. يمكنك متابعة الحالات المرضية، تحديد المواعيد، والتفاعل مع المرضى بشكل فعال.</p>
            </div>

        </div>
    </div>



@endsection

@extends('layouts.master')
@section('page')

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <div class="dashboard-container">
        <div class="sidebar">
            <h3>لوحة التحكم</h3>

            <a href="{{route('exemption')}}">الادوات المطلوبة </a><br>
            <a href="{{route('exemption2')}}"> الادوات التي تم صرفها </a><br>
            <a href="{{route('employee.filter')}}"> الفرز حسب الاعاقة</a><br>
            <a href="{{route('employee.filter2')}}"> الفرز حسب المنطقة</a><br>
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
                <i class="fa-solid fa-clipboard-list fa-3x" style="color: #2980b9;"></i>
                <h2>مرحباً بك في لوحة المتابعة الإدارية</h2>
                <p>يمكنك من هنا إدارة الجداول، مراجعة البيانات، ومتابعة المهام اليومية بكل سهولة.</p>
            </div>
        </div>
    </div>



@endsection

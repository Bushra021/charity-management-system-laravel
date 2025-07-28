@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.master')

@section('page')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <div class="dashboard-container">

        <div class="sidebar">
            <h3>لوحة التحكم</h3>
            <a href="{{ route('admin.role') }}">صلاحيات المستخدمين</a>
            <a href="{{route('posts.create')}}">نشر الأخبار والمحتوى</a>
            <a href="/areas">توزيع المناطق</a>
            <a href="/tools">إدارة الأدوات</a>
            <a href="/services">الخدمات المقدّمة</a>
            <a href="/grades">تصنيفات الإعاقة</a>
            <a href="/disability causes"> أسباب الإعاقة</a>
            <a href="/disability types">أنواع الإعاقة المسجلة</a>
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


            <div class="welcome-message">
                <i class="fa-solid fa-user-shield fa-3x" style="color: #2c3e50; font-size: 45px"></i>
                <h2>مرحباً بك في النظام الإداري</h2>
                <p>هذه هي الواجهة الإدارية الخاصة بك.يرجى اختيار القسم الذي تود العمل عليه من القائمة الجانبية.</p>
            </div>

        </div>
    </div>

@endsection

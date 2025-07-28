@extends('layouts.master')

<meta name="csrf-token" content="{{ csrf_token() }}">

@push('css')
    <link href="{{ asset('css/role.css') }}" rel="stylesheet">
@endpush

@section('page')

    <div class="dashboard-container">
        <!-- الشريط الجانبي -->
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

        <!-- المحتوى الرئيسي -->
        <div class="main-content">
            <!-- التوب بار -->
            <div class="main-content">
                <div class="header">
                    <div class="user-name">مرحباً، {{ auth()->user()->name }}</div>
                    <img src="{{ asset('storage/' . (Auth::user()->profile_picture ?? 'defaults/profile.jpg')) }}" width="150" alt="الصورة الشخصية">
                    <div class="logout-btn">
                        <a href="{{ route('logout') }}">تسجيل الخروج</a>
                    </div>
                </div>

            <!-- محتوى الصفحة -->
            <div class="content">
                <div class="page-header-with-button">
                    <h1 class="page-header">إدارة المستخدمين</h1>
                </div>

                <!-- مربع البحث -->
                <input type="text" id="search" class="form-control" placeholder="ابحث عن اسم المستخدم أو اسمه..." style="margin-bottom: 15px; max-width: 400px;">

                <!-- جدول المستخدمين -->
                <div id="master">
                    <table class="table table-striped" id="userTable">
                        <thead>
                        <tr>
                            <th>المعرف</th>
                            <th>الاسم</th>
                            <th>اسم المستخدم</th>
                            <th>الدور الحالي</th>
                            <th>تعديل الدور</th>
                            <th>حالة الحساب</th>
                            <th>تعديل حالة الحساب</th>

                        </tr>
                        </thead>
                        <tbody>
                        @include('admin.table', ['users' => $users])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('js/role.js') }}"></script>
@endpush

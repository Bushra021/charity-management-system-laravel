@extends('layouts.master')

@section('page')

    <link href="{{ asset('css/profile.css') }}" rel="stylesheet" >



    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <div class="dashboard-container">
        <div class="sidebar">
            <h3>لوحة التحكم</h3>

            @php
                $role = auth()->user()->role;
            @endphp

            @if($role === 'employee_services')
                <a href="{{route('appointment.index')}}">المواعيد</a><br>
                <a href="{{route('search-patient')}}"> الملاحظات </a><br>
                <a href="{{route('employee.service')}}">الخدمات المطلوبة </a><br>
                <a href="{{route('employee.service done')}}">الخدمات الجارية والمنهية </a><br>


            @elseif($role === 'employee')
                <a href="{{route('exemption')}}">الادوات المطلوبة </a><br>
                <a href="{{route('exemption2')}}"> الادوات التي تم صرفها </a><br>
                <a href="{{route('employee.filter')}}"> الفرز حسب الاعاقة</a><br>
                <a href="{{route('employee.filter2')}}"> الفرز حسب المنطقة</a><br>


            @elseif($role === 'admin')
                <a href="{{ route('admin.role') }}">صلاحيات المستخدمين</a>
                <a href="{{route('posts.create')}}">نشر الأخبار والمحتوى</a>
                <a href="/areas">توزيع المناطق</a>
                <a href="/tools">إدارة الأدوات</a>
                <a href="/services">الخدمات المقدّمة</a>
                <a href="/grades">تصنيفات الإعاقة</a>
                <a href="/disability causes"> أسباب الإعاقة</a>
                <a href="/disability types">أنواع الإعاقة المسجلة</a>

            @elseif($role === 'patient')
                <a href="{{route('profile.info')}}">المعلومات الشخصية </a><br>

                <a href="{{route('appointments.available')}}">الحجوزات والمواعيد </a><br>

                <a href="{{route('assistive tool.create')}}">الادوات  </a><br>

                <a href="{{route('provided services.create')}}">الخدمات </a> <br>

                <a href="{{route('patient.reports.create')}}">التقارير </a> <br>

            @endif

            <a href="{{ route('profile.show') }}">معلومات الحساب</a><br>
        </div>
        <div class="main-content">
            <div class="header">
                <div class="user-name">مرحباً، {{ auth()->user()->name }}</div>
                <img src="{{ asset('storage/' . (Auth::user()->profile_picture ?? 'defaults/profile.jpg')) }}" width="150" alt="الصورة الشخصية">
                <div class="logout-btn">
                    <a href="{{ route('logout') }}">تسجيل الخروج</a>
                </div>
            </div>
            <div class="container">

                <h2>الملف الشخصي</h2>

                <form  action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label for="profile_picture">الصورة الشخصية:</label>
                    <img id="image-preview"
                         src="{{ asset($user->profile_picture ? 'storage/' . $user->profile_picture : 'storage/defaults/profile.jpg') }}"
                         alt="الصورة الشخصية"
                         class="current-image"
                    >
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" onchange="previewImage(event)">

                    <label for="name">الاسم:</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}">

                    <p><strong>المنطقة:</strong> {{ $user->area->name }}</p>
                    <p><strong>الجنس:</strong> {{ $user->gender }}</p>

                    <label for="username">البريد الإلكتروني:</label>
                    <input type="email" name="username" id="username" value="{{ old('username', $user->username) }}">

                    <button type="submit">حفظ التعديلات</button>
                </form>
            </div>


        </div>
    </div>





    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('image-preview');

            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        }

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'تم التحديث',
            text: '{{ session('success') }}',
            confirmButtonText: 'موافق'
        });
        @endif

    </script>

@endsection

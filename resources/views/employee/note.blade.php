@extends('layouts.master')
@push('css')
    <link href="{{ asset('css/role.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="{{ asset('css/note.css') }}" rel="stylesheet">
@endpush
@section('page')


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
            <div class="container">
                <h2>إضافة ملاحظة لمريض</h2>

                {{-- نموذج البحث --}}
                <form method="GET" action="{{ route('search-patient') }}">
                    <div class="mb-3">
                        <label for="search" class="form-label">ابحث عن المريض</label>
                        <input type="text" name="query" id="search" class="form-control" placeholder="أدخل اسم المريض أو رقم الهوية" value="{{ request('query') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">بحث</button>
                </form>

                {{-- عرض النتائج إن وجدت --}}
                @if(isset($patients) && count($patients) > 0)
                    <div class="mt-4">
                        <h4>النتائج:</h4>
                        <ul class="list-group">
                            @foreach($patients as $patient)
                                <li class="list-group-item d-flex justify-content-between align-items-center">

                                    <a href="{{ route('employee.patient.view', $patient->id) }}">
                                        {{ $patient->name }}- {{ $patient->national_id }}
                                        @php
                                            $profilePicture = $patient->user->profile_picture ?? null;
                                        @endphp

                                    </a>

                                    <a href="{{ route('showPatient', $patient->id) }}" class="btn btn-sm btn-success">إضافة ملاحظة</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @elseif(request()->has('query'))
                    <div class="alert alert-warning mt-4">
                        لا يوجد مرضى مطابقين للشروط.
                    </div>
                @endif
            </div>



        </div>
    </div>





@endsection
@push('js')
    <script src="{{ asset('js/role.js') }}"></script>
@endpush

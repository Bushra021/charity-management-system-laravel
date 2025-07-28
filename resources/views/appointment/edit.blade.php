@extends('layouts.master')

@section('page')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap');

        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            background-color: #f9f9f9;
            color: #333;
            margin-top: 40px;
        }

        /* الحاوية العامة */
        .container {
            max-width: 900px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        /* العنوان */
        h1 {
            font-size: 24px;
            color: #198754;
            margin-bottom: 24px;
            text-align: center;
        }

        /* العناوين */
        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        /* الحقول */
        .form-control {
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 15px;
        }

        /* زر الحفظ */
        button[type="submit"] {
            background-color: #198754;
            border: none;
            padding: 10px 24px;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #157347;
        }

        /* رسائل الخطأ */
        .text-danger {
            font-size: 13px;
            margin-top: 4px;
            display: block;
        }

        /* المسافات بين الحقول */
        .form-group {
            margin-bottom: 18px;
        }

        /* ✅ Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 20px;
            }

            .form-control {
                font-size: 14px;
                padding: 8px 10px;
            }

            button[type="submit"] {
                font-size: 15px;
                padding: 8px 20px;
            }
        }

    </style>
@endpush


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
            <h1 class="mb-4">تعديل الموعد</h1>

            <form action="{{ route('appointment.update', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="service_id">الخدمة:</label>
                    <select name="service_id" id="service_id" class="form-control" required>
                        <option value="">اختر خدمة</option>
                        @foreach(Auth::user()->services as $service)
                            <option value="{{ $service->id }}"
                                {{ (old('service_id') ?? $appointment->service_id) == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="date">التاريخ:</label>
                    <input type="date" name="date" id="date" class="form-control"
                           value="{{ old('date', $appointment->date) }}" required>
                    @error('date')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="start_time">بداية الوقت:</label>
                    <input type="time" name="start_time" id="start_time" class="form-control"
                           value="{{ old('start_time', $appointment->start_time) }}" required>
                    @error('start_time')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="end_time">نهاية الوقت:</label>
                    <input type="time" name="end_time" id="end_time" class="form-control"
                           value="{{ old('end_time', $appointment->end_time) }}" required>
                    @error('end_time')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-4">تحديث الموعد</button>
            </form>
        </div>


        </div>
    </div>


@endsection

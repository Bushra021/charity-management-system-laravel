@extends('layouts.master')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@section('page')
    @push('css')
        <style>
            body {
                font-family: 'Cairo', sans-serif;
                background-color: #f5f7f6;
                color: #333;
                margin: 0;
                padding: 0;
                direction: rtl;
            }

            /* تنسيق الحاوية العامة */
            .container {
                max-width: 900px;
                margin: 40px auto;
                background-color: #fff;
                padding: 30px 20px;
                border-radius: 12px;
                box-shadow: 0 0 10px rgba(0,0,0,0.05);
            }

            /* عنوان الفلترة */
            label {
                font-size: 24px;
                font-weight: bold;
                display: block;
                margin-bottom: 8px;
            }

            /* حقل الاختيار */
            #disability_type_id {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 8px;
                font-size: 18px;
                margin-bottom: 15px;
            }

            /* زر الفلترة */
            form button {
                font-size: 18px;
                background-color: #28a745;
                color: white;
                border: none;
                padding: 10px 24px;
                border-radius: 8px;
                transition: background-color 0.3s;
            }

            form button:hover {
                background-color: #218838;
            }

            /* عنوان القائمة */
            h3 {
                font-size: 24px;
                margin-top: 30px;
                margin-bottom: 15px;
                color: #222;
                font-weight: bold;
            }

            p{
                font-size: 20px;
                text-align: center;
                color: black;
                margin: 25px 15px;
            }
            /* شبكة المرضى */
            ul {
                list-style: none;
                padding: 0;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 20px;
                margin-top: 20px;
            }

            /* عنصر مريض */
            ul li {
                background-color: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 12px;
                padding: 20px 15px;
                transition: box-shadow 0.3s;
                text-align: center;
                min-height: 160px;
            }

            ul li:hover {
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }

            /* رابط المريض */
            ul li a {
                text-decoration: none;
                color: #222;
                font-weight: 600;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 12px;
            }

            /* صورة المريض */
            ul li img {
                width: 65px;
                height: 65px;
                object-fit: cover;
                border-radius: 50%;
                border: 2px solid #28a745;
            }

            /* موبايل */
            @media (max-width: 576px) {
                .container {
                    padding: 20px 15px;
                }

                h3 {
                    font-size: 20px;
                    text-align: center;
                }

                form button {
                    width: 100%;
                    margin-top: 10px;
                }

                #disability_type_id {
                    width: 100%;
                }

                ul {
                    grid-template-columns: 1fr;
                }
            }

        </style>
    @endpush
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
            <div class="container">
                <form method="GET" action="{{ route('employee.filter') }}">
                    {{-- فلترة حسب نوع الإعاقة --}}
                    <label for="disability_type_id">اختر نوع الإعاقة:</label>
                    <select name="disability_type_id" id="disability_type_id">
                        <option value="">-- اختر --</option>
                        @foreach ($disabilityTypes as $type)
                            <option value="{{ $type->id }}" {{ request('disability_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit">فرز حسب الإعاقة</button>
                </form>
                @if($disabilityPatients->isNotEmpty())
                    <h3>
                        المرضى حسب نوع الإعاقة
                        <span style="font-weight: normal; color:#555;">
            ({{ $disabilityPatients->count() }} مريض)
        </span>
                    </h3>

                    <ul>
                        @foreach ($disabilityPatients as $patient)
                            <li>
                                <a href="{{ route('employee.patient.view', $patient->id) }}">
                                    {{ $patient->name }}

                                    @php
                                        $profilePicture = $patient->user->profile_picture ?? null;
                                    @endphp

                                    @if($profilePicture && Storage::disk('public')->exists($profilePicture))
                                        <img src="{{ asset('storage/' . $profilePicture) }}" width="40"
                                             alt="الصورة الشخصية"
                                             style="border-radius:50%;object-fit:cover;height:60px;">
                                    @else
                                        <img src="{{ asset('defaults/profile.jpg') }}" width="40"
                                             alt="الصورة الافتراضية"
                                             style="border-radius:50%;object-fit:cover;height:60px;">
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @elseif(request()->has('disability_type_id'))
                    <p>لا يوجد مرضى لهذا النوع من الإعاقة.</p>
                @endif
            </div>

        </div>
    </div>

@endsection

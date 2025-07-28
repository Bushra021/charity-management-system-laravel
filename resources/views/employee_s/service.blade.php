@extends('layouts.master')

@section('page')

    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap');

            body {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 0;
                font-family: 'Cairo', sans-serif;
                background-color: #f8f9fa;
                direction: rtl;
                color: #333;
                box-sizing: border-box;
            }


            h4 {
                color: #155724;
                text-align: center;
                margin-bottom: 20px;
                font-weight: bold;
            }

            .table {

                background-color: white;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            }

            .table th, .table td {
                text-align: center;
                vertical-align: middle;
                padding: 12px;
                font-size: 15px;
                border: 1px solid #dee2e6;
            }

            .table thead {
                background-color: #e9f7ef;
                font-weight: bold;
            }

            .btn {
                font-size: 14px;
                padding: 6px 14px;
                border-radius: 6px;
            }

            .btn-success {
                background-color: #198754;
                border: none;
                color: white;
            }

            .btn-success:hover {
                background-color: #157347;
            }

            .btn-primary {
                background-color: #0d6efd;
                border: none;
                color: white;
            }

            .btn-primary:hover {
                background-color: #0b5ed7;
            }

            .d-flex.gap-2 {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 10px;
            }

            .text-center {
                font-size: 16px;
                color: #999;
                padding: 16px;
            }

            @media (max-width: 768px) {
                h4 {
                    font-size: 18px;
                }

                .table th, .table td {
                    font-size: 13px;
                    padding: 8px;
                }

                .btn {
                    font-size: 13px;
                    padding: 5px 10px;
                }

                .d-flex.gap-2 {
                    flex-direction: column;
                    gap: 6px;
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
            <h4 class="mt-4">الخدمات المطلوبة قيد الانتظار</h4>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>اسم الخدمة</th>
                    <th>اسم المريض</th>
                    <th>تاريخ البدء</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الحالة</th>
                    <th>هل تلقاها من قبل؟</th>
                    <th>إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($services as $item)
                    <tr>
                        <td>{{ $item->service->name ?? 'غير متوفر' }}</td>
                        <td>{{$item->patient->name??'غير متوفر'}}</td>
                        <td>{{ $item->start_date ?? '-' }}</td>
                        <td>{{ $item->end_date ?? '-' }}</td>
                        <td>
                            @php
                                $statusMap = [
                                    'pending'   => ' لقد تم طلبها ',
                                    'scheduled' => 'يتلفاها الان  ',
                                    'completed' => 'مكتملة',
                                ];
                            @endphp
                            {{ $statusMap[$item->status] ?? 'غير معروف' }}
                        </td>
                        <td>{{ $item->received ? 'نعم' : 'لا' }}</td>

                        {{-- زرّا البدء والإنهاء --}}
                        <td class="d-flex gap-2">
                            @if($item->status === 'pending')
                                <form method="POST" action="{{ route('provided_service.start', $item->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">بدء الخدمة</button>
                                </form>
                            @endif

                            @if($item->status === 'scheduled')
                                <form method="POST" action="{{ route('provided_service.complete', $item->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">إنهاء الخدمة</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">لا توجد خدمات حالياً.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>



@endsection

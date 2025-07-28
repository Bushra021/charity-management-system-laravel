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


            .mt-4 {
                max-width: 1000px;
                margin: 0 auto;
                padding: 20px;
            }

            h4 {
                text-align: center;
                font-size: 24px;
                color: #155724;
                margin-bottom: 24px;
            }

            .table {
                background-color: #fff;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            .table thead th {
                background-color: #e2f0e8;
                color: #155724;
                text-align: center;
                font-weight: bold;
                padding: 14px;
                font-size: 16px;
                border-bottom: 1px solid #d1e7dd;
            }

            .table td {
                text-align: center;
                vertical-align: middle;
                padding: 12px;
                font-size: 15px;
            }

            .btn-sm {
                padding: 6px 14px;
                font-size: 13px;
                border-radius: 6px;
            }

            .btn-success {
                background-color: #198754;
                color: white;
                border: none;
            }

            .btn-success:hover {
                background-color: #157347;
            }

            .btn-primary {
                background-color: #0d6efd;
                color: white;
                border: none;
            }

            .btn-primary:hover {
                background-color: #0b5ed7;
            }

            .text-center {
                text-align: center;
                font-size: 15px;
                color: #6c757d;
            }

            @media (max-width: 768px) {
                .table thead th,
                .table td {
                    font-size: 13px;
                    padding: 8px;
                }

                h4 {
                    font-size: 20px;
                    text-align: center;
                }

                .mt-4{
                    margin: auto;
                }
                .btn-sm {
                    font-size: 12px;
                    padding: 5px 10px;
                }
            }
            @media (max-width: 500px) {
                .mt-4 {
                    margin: auto;
                }

                h4 {
                    font-size: 15px;
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

            <h4 class="mt-4">الخدمات الجارية والمنهية</h4>

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
                @forelse($servicedone as $item)
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


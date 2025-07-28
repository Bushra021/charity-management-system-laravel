@extends('layouts.master')

@push('css')
    <link href="{{asset('css/svc.css')}}" rel="stylesheet">
@endpush

@section('page')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <div class="dashboard-container">

        <div class="sidebar">
            <h3>لوحة التحكم</h3>

            <a href="{{route('profile.info')}}">المعلومات الشخصية </a><br>

            <a href="{{route('appointments.available')}}">الحجوزات والمواعيد </a><br>

            <a href="{{route('assistive tool.create')}}">الادوات  </a><br>

            <a href="{{route('provided services.create')}}">الخدمات </a> <br>

            <a href="{{route('patient.reports.create')}}">التقارير </a> <br>
            <a href="{{route('profile.show')}}">معلومات الحساب</a>
        </div>

        <div class="main-content">
            <div class="header">
                <div class="user-name">مرحباً،
                    {{auth()->user()->name}}
                </div>

                <img src="{{ asset('storage/' . (Auth::user()->profile_picture ?? 'defaults/profile.jpg')) }}" width="150" alt="الصورة الشخصية">
                <div class="logout-btn">
                    <a href="{{route('logout')}}">تسجيل خروج </a><br>
                </div>
            </div>
            {{-- 🔔 تنبيه إذا لا توجد خدمات نشطة --}}
            @if($provided->isEmpty())
                <div class="alert alert-warning my-3">
                    لا يمكنك حجز موعد حالياً. يجب أولاً طلب خدمة من القائمة المتاحة.
                    <a href="{{ route('provided services.create') }}" class="btn btn-outline-warning btn-sm ms-2">
                        طلب خدمة جديدة
                    </a>
                </div>
            @endif

            <div class="container mt-4">

                {{-- ✅ رسائل النظام --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- ✅ مواعيدي المحجوزة --}}
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>  مواعيدي المحجوزة</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($appointmentava->isNotEmpty())
                            <table class="table table-striped table-bordered align-middle text-center mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th>الخدمة</th>
                                    <th>التاريخ</th>
                                    <th>يبدأ</th>
                                    <th>ينتهي</th>
                                    <th>الإجراء</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($appointmentava as $appointment)
                                    <tr class="{{ $appointment->status === 'canceled' ? 'table-danger' : '' }}">
                                        <td>{{ $appointment->service->name ?? '-' }}</td>
                                        <td>{{ $appointment->date }}</td>
                                        <td>{{ $appointment->start_time }}</td>
                                        <td>{{ $appointment->end_time }}</td>
                                        <td>
                                            @if($appointment->status !== 'canceled')
                                                <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد من إلغاء هذا الموعد؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="إلغاء الموعد">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge bg-danger">تم إلغاؤه</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-3 text-muted">لا توجد حجوزات لديك حالياً.</div>
                        @endif
                    </div>
                </div>

                {{-- ✅ المواعيد المتاحة --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>المواعيد المتاحة</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($appointments->isNotEmpty())
                            <table class="table table-bordered align-middle text-center mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th>الخدمة</th>
                                    <th>التاريخ</th>
                                    <th>من</th>
                                    <th>إلى</th>
                                    <th>الإجراء</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->service->name ?? '-' }}</td>
                                        <td>{{ $appointment->date }}</td>
                                        <td>{{ $appointment->start_time }}</td>
                                        <td>{{ $appointment->end_time }}</td>
                                        <td>
                                            @if(!$appointment->is_booked)
                                                <form method="POST" action="{{ route('appointments.book', $appointment->id) }}" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="حجز الموعد">
                                                        <i class="fas fa-check-circle me-1"></i> حجز
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge bg-secondary">تم حجزه</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-3 text-muted">لا توجد مواعيد متاحة حالياً.</div>
                        @endif
                    </div>
                </div>

            </div>



        </div>
    </div>



@endsection

@extends('layouts.master')

@push('css')
    <link href="{{asset('css/appoint.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
            <div class="container mt-4">
                <!-- 🔖 العنوان وزر إضافة -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>  مواعيدي </h3>
                    <a href="{{ route('appointment.create') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle me-1"></i> إضافة موعد جديد
                    </a>
                </div>


                <!-- 🔖 جدول المواعيد -->
                @if($appointments->isNotEmpty())
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <table class="table table-striped table-bordered align-middle text-center mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th>الخدمة</th>
                                    <th>التاريخ</th>
                                    <th>من</th>
                                    <th>إلى</th>
                                    <th>اسم المريض</th>
                                    <th>الحالة</th>
                                    <th>إجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($appointments as $appointment)
                                    <tr class="{{ $appointment->is_booked ? 'table-danger' : '' }}">
                                        <td>{{ $appointment->service->name ?? '-' }}</td>
                                        <td>{{ $appointment->date }}</td>
                                        <td>{{ $appointment->start_time }}</td>
                                        <td>{{ $appointment->end_time }}</td>
                                        <td>{{ optional(optional($appointment->appointment)->patient)->name ?? '-' }}</td>
                                        <td>
                                    <span class="badge {{ $appointment->is_booked ? 'bg-danger' : 'bg-success' }}">
                                        {{ $appointment->is_booked ? 'محجوز' : 'متاح' }}
                                    </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('appointment.edit', $appointment->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('appointment.destroy', $appointment->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد من حذف الموعد؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="حذف">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        لا يوجد مواعيد متاحة حالياً.
                    </div>

                    <div class="text-center my-3">
                        <a href="{{ route('appointment.create') }}" class="btn btn-success">
                            <i class="fas fa-plus-circle me-1"> </i> إضافة موعد جديد
                        </a>
                    </div>

                @endif
            </div>

        </div>
    </div>

@endsection

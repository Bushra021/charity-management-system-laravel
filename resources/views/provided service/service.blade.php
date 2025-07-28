@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

@push('css')
    <link href="/css/areas.css" rel="stylesheet">
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
            <div class="container mt-4">

                {{-- ✅ الخدمات التي تم طلبها --}}
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i>الخدمات التي تم طلبها</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>اسم الخدمة</th>
                                <th>إلغاء الطلب</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($provided as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <form action="{{ route('provided service.destroy', $item->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">لا توجد خدمات مسجلة حتى الآن.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ✅ طلب خدمة جديدة --}}
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-plus-square me-2"></i>طلب خدمة جديدة</h5>
                    </div>
                    <form action="{{ route('provided services.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>الخدمة</th>
                                    <th>تلقاها</th>
                                    <th>يحتاج إليها</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($servicereqsted as $service)
                                    <tr>
                                        <td>{{ $service->name }}</td>
                                        <td><input type="checkbox" name="services[{{ $service->id }}][received]" value="1"></td>
                                        <td><input type="checkbox" name="services[{{ $service->id }}][needed]" value="1"></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="text-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-plus-circle me-1"></i> إضافة
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- ✅ الخدمات المجدولة أو المكتملة --}}
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>الخدمات المجدولة أو المكتملة</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>اسم الخدمة</th>
                                <th>تاريخ ابتداء الخدمة</th>
                                <th>تاريخ انتهاء الخدمة</th>
                                <th>الحالة</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($provideddone as $item)
                                <tr>
                                    <td>{{ $item->name ?? 'غير متوفر' }}</td>
                                    <td>{{ $item->start_date ?? '-' }}</td>
                                    <td>{{ $item->end_date ?? '-' }}</td>
                                    <td>
                                        @php
                                            $statusMap = [
                                                'pending'   => 'لقد تم طلبها',
                                                'scheduled' => 'يتلقاها الآن',
                                                'completed' => 'مكتملة',
                                            ];
                                        @endphp
                                        {{ $statusMap[$item->status] ?? 'غير معروف' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">لا توجد خدمات مجدولة أو مكتملة حالياً.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>



        </div>
    </div>

@endsection

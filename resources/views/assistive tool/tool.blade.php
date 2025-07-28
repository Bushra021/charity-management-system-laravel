@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
            <div class="container mt-4">

                {{-- ✅ الأدوات التي تم صرفها (مدفوعة) --}}
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-coins me-2"></i>   الأدوات التي تم صرفها (مدفوعة)</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>اسم الأداة</th>
                                <th>المصدر</th>
                                <th>القيمة المدفوعة</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($attachmentpaid as $item)
                                <tr>
                                    <td>{{ $item->tool_name }}</td>
                                    <td>{{ $item->source }}</td>
                                    <td>{{ number_format($item->attachments_price, 2) }} شيكل</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">لا توجد أدوات مدفوعة حالياً. </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ✅ الأدوات التي تم طلبها --}}
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>  الأدوات التي تم طلبها</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>اسم الأداة</th>
                                <th>السعر</th>
                                <th>إلغاء الطلب</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($attachment as $item)
                                <tr>
                                    <td>{{ $item->tool_name }}</td>
                                    <td>{{ number_format($item->price, 2) }} شيكل</td>
                                    <td>
                                        <form action="{{ route('assistive tool.destroy', $item->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">لا توجد أدوات مسجلة حتى الآن.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ✅ طلب أداة جديدة --}}
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-plus-square me-2"></i>   طلب أداة جديدة</h5>
                    </div>
                    <form action="{{ route('assistive tool.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if ($attachmentreqsted->isEmpty())
                                <div class="alert alert-info mb-0">لا توجد أدوات مطلوبة حاليًا.</div>
                            @else
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>الأداة</th>
                                        <th>السعر</th>
                                        <th>تلقاها</th>
                                        <th>يحتاج إليها</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($attachmentreqsted as $tool)
                                        <tr>
                                            <td>{{ $tool->name }}</td>
                                            <td>{{ number_format($tool->price, 2) }} شيكل</td>
                                            <td><input type="checkbox" name="tools[{{ $tool->id }}][received]" value="1"></td>
                                            <td><input type="checkbox" name="tools[{{ $tool->id }}][needed]" value="1"></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-plus-circle me-1"></i> إضافة
                                    </button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>

            </div>


        </div>
    </div>

@endsection

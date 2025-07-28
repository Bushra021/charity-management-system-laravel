@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

@push('css')
    <link href="{{ asset('css/service.css') }}" rel="stylesheet">
@endpush

@section('page')

    <!-- الشريط الجانبي -->

    <div class="dashboard-container">

        <div class="sidebar">
            <h3>لوحة التحكم</h3>
            <a href="{{ route('admin.role') }}">صلاحيات المستخدمين</a>
            <a href="{{route('posts.create')}}">نشر الأخبار والمحتوى</a>
            <a href="/areas">توزيع المناطق</a>
            <a href="/tools">إدارة الأدوات</a>
            <a href="/services">الخدمات المقدّمة</a>
            <a href="/grades">تصنيفات الإعاقة</a>
            <a href="/disability causes"> أسباب الإعاقة</a>
            <a href="/disability types">أنواع الإعاقة المسجلة</a>
            <a href="{{route('profile.show')}}">معلومات الحساب</a>
        </div>


        <!-- المحتوى الرئيسي -->
        <div class="main-content">
            <!-- التوب بار -->
            <div class="header">
                <div class="user-name">مرحباً، {{ auth()->user()->name }}</div>
                <div class="logout-btn">
                    <a href="{{ route('logout') }}">تسجيل الخروج</a>
                </div>
            </div>

            {{-- محتوى الصفحة --}}
            <div class="content">
                <div class="page-header-with-button">
                    <h1 class="page-header">الخدمات المقدّمة</h1>
                    <button class="btn btn-add" id="add">إضافة خدمة</button>
                </div>

                <div id="master">
                    <table class="table table-striped" id="table">
                        <thead>
                        <tr>
                            <th>الرقم</th>
                            <th>اسم الخدمة</th>
                            <th>الموظف المسؤول</th>
                            <th>الحالة</th>
                            <th>تعديل</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody id="myservicelist">
                        @foreach($services as $service)
                            <tr id="service_no_{{ $service->id }}">
                                <td>{{ $service->id }}</td>
                                <td id="service_name_{{ $service->id }}">{{ $service->name }}</td>
                                <td id="service_user_id_{{ $service->id }}" data-userid="{{ $service->user_id }}">
                                    {{ $service->user->name ?? '---' }}
                                </td>
                                <td>
                                    <button class="btn btn-sm toggle-active {{ $service->is_active ? 'btn-success' : 'btn-secondary' }}"
                                            data-id="{{ $service->id }}">
                                        {{ $service->is_active ? 'مفعّلة' : 'غير مفعّلة' }}
                                    </button>
                                </td>
                                <td>
                                    <span class="btn btn-success btn-sm edit" data-service-id="{{ $service->id }}">تعديل</span>
                                </td>
                                <td>
                                    <span class="btn btn-danger btn-sm delete" data-service-id="{{ $service->id }}">حذف</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- نهاية المحتوى --}}
        </div>
    </div>

    {{-- المودال --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة خدمة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <form id="myform">
                        <div class="mb-3">
                            <label for="name">اسم الخدمة</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="user_id">الموظف المسؤول</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="">اختر الموظف</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" id="btn" class="btn btn-add w-100">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('js/service.js') }}"></script>
@endpush

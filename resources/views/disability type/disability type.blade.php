@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

@push('css')
    <link href="{{ asset('css/disability type.css') }}" rel="stylesheet">
@endpush

@section('page')

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
                    <h1 class="page-header">أنواع الإعاقة المسجلة</h1>
                    <button class="btn btn-add" id="add">إضافة نوع الإعاقة</button>
                </div>

                <div id="master">
                    <table class="table table-striped" id="table">
                        <thead>
                        <tr>
                            <th scope="col">الرقم</th>
                            <th scope="col">نوع الإعاقة</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody id="mydisabilitytypelist">
                        @foreach($disability_types as $disability_type)
                            <tr id="disability_type_no_{{$disability_type->id}}">
                                <td>{{ $disability_type->id }}</td>
                                <td id="disability_type_name_{{$disability_type->id}}">{{ $disability_type->name }}</td>
                                <td>
                                    <span class="btn btn-success btn-sm edit" disabilitytype_id="{{ $disability_type->id }}">تعديل</span>
                                </td>
                                <td>
                                    <span class="btn btn-danger btn-sm delete" disabilitytype_id="{{ $disability_type->id }}">حذف</span>
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
    <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة أو تعديل نوع الإعاقة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <form id="myform">
                        <input type="hidden" name="id" id="disability_type_id">
                        <div class="mb-3">
                            <label for="name" class="form-label">نوع الإعاقة</label>
                            <input type="text" placeholder="أدخل النوع" name="name" id="name" class="form-control" required>
                        </div>
                        <button type="submit" id="btn" class="btn btn-success">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="/js/disability type.js"></script>
@endpush

@extends('layouts.master')

<meta name="csrf-token" content="{{ csrf_token() }}">

@push('css')
    <link href="/css/tool.css" rel="stylesheet">
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

        <div class="main-content">
            <div class="header">
                <div class="user-name">مرحباً، {{ auth()->user()->name }}</div>
                <div class="logout-btn">
                    <a href="{{ route('logout') }}">تسجيل الخروج</a>
                </div>
            </div>

            {{-- محتوى الصفحة --}}
            <div class="content">
                <div class="page-header-with-button">
                    <h1 class="page-header">إدارة الأدوات</h1>
                    <button class="btn btn-add" id="add">إضافة أداة</button>
                </div>

                <div id="master">
                    <table class="table table-striped" id="table">
                        <thead>
                        <tr>
                            <th scope="col">الرقم</th>
                            <th scope="col">الاسم</th>
                            <th scope="col">السعر</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody id="mytoollist">
                        @foreach($tools as $tool)
                            <tr id="tool_no_{{$tool->id}}">
                                <th>{{$tool->id}}</th>
                                <td id="tool_name_{{$tool->id}}">{{$tool->name}}</td>
                                <td id="tool_price_{{$tool->id}}">{{$tool->price}}</td>
                                <td>
                                    <span class="btn btn-success btn-sm edit" tool_id="{{$tool->id}}">تعديل</span>
                                </td>
                                <td>
                                    <span class="btn btn-danger btn-sm delete" tool_id="{{$tool->id}}">حذف </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- نهاية محتوى الصفحة --}}
        </div>
    </div>

    {{-- المودال --}}
    <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة أو تعديل الأداة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="myform">
                        <input type="hidden" name="id" id="tool_id">
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم الأداة</label>
                            <input type="text" placeholder="أدخل اسم الأداة" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">السعر</label>
                            <input type="number" placeholder="أدخل سعر الأداة" name="price" id="price" class="form-control" step="0.01" required>
                        </div>
                        <button type="submit" id="btn" class="btn btn-success">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="/js/tool.js"></script>
@endpush

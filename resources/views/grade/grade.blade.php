@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

@push('css')
    <link href="{{ asset('css/grade.css') }}" rel="stylesheet">
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
                    <h1 class="page-header">تصنيفات درجات الإعاقة</h1>
                    <button class="btn btn-add" id="add">إضافة درجة الإعاقة</button>
                </div>

                <div id="master">
                    <table class="table table-striped" id="table">
                        <thead>
                        <tr>
                            <th scope="col">الرقم</th>
                            <th scope="col">الدرجة</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody id="mygradelist">
                        @foreach($grades as $grade)
                            <tr id="grade_no_{{$grade->id}}">
                                <td>{{ $grade->id }}</td>
                                <td id="grade_name_{{$grade->id}}">{{ $grade->name }}</td>
                                <td>
                                    <span class="btn btn-success btn-sm edit" data-grade-id="{{ $grade->id }}">تعديل</span>
                                </td>
                                <td>
                                    <span class="btn btn-danger btn-sm delete" data-grade-id="{{ $grade->id }}">حذف</span>
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
                    <h5 class="modal-title" id="exampleModalLabel">إضافة درجة الإعاقة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <form id="myform">
                        <input type="text" placeholder="أدخل درجة الإعاقة" name="name" id="name" class="form-control" required>
                        <br/>
                        <button type="submit" id="btn" class="btn btn-add">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="/js/grade.js"></script>
@endpush

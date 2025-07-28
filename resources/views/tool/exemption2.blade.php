@extends('layouts.master')


@section('page')

    @push('css')
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap');

            body {
                font-family: 'Cairo', sans-serif;
                direction: rtl;
                background-color: #f8f9fa;
                margin: 0;
                padding: 0;
            }

            /* الحاوية */
            .container {
                max-width: 1000px;
                margin: 20px auto;
                padding: 20px;
            }

            /* العنوان */
            h2 {
                color: #155724;
                font-weight: bold;
                margin-bottom: 24px;
                text-align: center;
            }

            /* الجدول */
            .table {
                background-color: #fff;
                border: 1px solid #dee2e6;
            }

            .table th {
                background-color: #e2f0e8;
                color: #155724;
                font-size: 16px;
                text-align: center;
                vertical-align: middle;
            }

            .table td {
                text-align: center;
                vertical-align: middle;
                font-size: 15px;
                padding: 12px;
            }

            /* select و input داخل الجدول */
            select, .form-control {
                width: 100%;
                padding: 6px 10px;
                font-size: 14px;
                border-radius: 6px;
                border: 1px solid #ced4da;
            }

            /* الزر */
            .btn-info {
                background-color: #17a2b8;
                border: none;
                color: white;
                padding: 6px 12px;
                font-size: 14px;
                border-radius: 6px;
                transition: 0.3s;
            }

            .btn-info:hover {
                background-color: #138496;
            }

            /* التنبيه */
            .alert-warning {
                background-color: #fff3cd;
                color: #856404;
                border-radius: 6px;
                padding: 16px;
                font-size: 15px;
            }

            /* ريسبونسيف */
            @media (max-width: 768px) {
                .table-responsive {
                    overflow-x: auto;
                }

                .table th, .table td {
                    font-size: 13px;
                    padding: 10px;
                }

                select, .form-control {
                    font-size: 13px;
                }

                .btn-info {
                    font-size: 13px;
                    padding: 5px 10px;
                }

                h2 {
                    font-size: 20px;
                    text-align: center;
                }
            }


        </style>
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush
    <div class="dashboard-container">
        <div class="sidebar">
            <h3>لوحة التحكم</h3>

            <a href="{{route('exemption')}}">الادوات المطلوبة </a><br>
            <a href="{{route('exemption2')}}"> الادوات التي تم صرفها </a><br>
            <a href="{{route('employee.filter')}}"> الفرز حسب الاعاقة</a><br>
            <a href="{{route('employee.filter2')}}"> الفرز حسب المنطقة</a><br>
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

            <div class="container">
                <h2 class="my-4">الأدوات المطلوبة</h2>

                @if($data->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>اسم الأداة</th>
                                <th>السعر الاصلي</th>
                                <th>اسم المريض</th>
                                <th>الاعفاءات</th>
                                <th>السعر المدفوع </th>
                                <th>الاجراء</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tool_name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->patient_name }}</td>
                                    <td>
                                        <form action="{{ route('exemption.source', $item->id) }}" method="POST">
                                            @csrf
                                            <select name="source" id="source" required>
                                                <option value="مساهمة" {{ $item->source == 'مساهمة' ? 'selected' : '' }}>مساهمة</option>
                                                <option value="اعفاء" {{ $item->source == 'اعفاء' ? 'selected' : '' }}>إعفاء</option>
                                                <option value="مجانا" {{ $item->source == 'مجانا' ? 'selected' : '' }}>مجانا</option>
                                            </select>

                                            <td>

                                                <input type="number" step="0.01" name="price" id="price" class="form-control"
                                                       value="{{ old('price', $item->attachments_price) }}">
                                                @error('price')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> تحديث
                                                </button>
                                            </td>
                                        </form>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning">
                        لا توجد إعفاءات مطلوبة حالياً.
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection


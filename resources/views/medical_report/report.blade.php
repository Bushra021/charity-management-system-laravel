@extends('layouts.master')

@section('page')
    @push('css')
        <style>
            body {
                font-family: 'Cairo', sans-serif;
                background-color: #f9f9f9;
                direction: rtl;
            }

            .container {
                max-width: 900px;
                margin: 40px auto;
                background-color: #fff;
                padding: 25px;
                border-radius: 12px;
                box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            }

            h2{
                color: #28a745;
                font-weight: 600;
                margin-bottom: 20px;
                font-size: 30px;
                text-align: center;
            }
            h3 {
                color: #28a745;
                font-weight: 600;
                margin-bottom: 20px;
                font-size: 25px;
            }

            /* تنسيق الحقول */
            label.form-label {
                font-size: 20px;
                font-weight: 500;
                margin-bottom: 5px;
                display: block;
                color: #333;
            }

            input.form-control {
                font-size: 20px;
                padding: 10px;
                border-radius: 8px;
                border: 1px solid #ccc;
                transition: border-color 0.3s ease;
            }

            input.form-control:focus {
                border-color: #28a745;
                outline: none;
                box-shadow: 0 0 5px rgba(40, 167, 69, 0.2);
            }

            /* زر الرفع */
            button.btn-primary {
                background-color: #28a745;
                border: none;
                padding: 10px 20px;
                font-size: 20px;
                text-align: center;
                font-weight: 500;
                border-radius: 8px;
                transition: 0.3s;
            }

            button.btn-primary:hover {
                background-color: #218838;
            }

            p{
                font-size: 22px;
                font-weight: 500;
                margin-top: 20px;
                text-align: center;
            }
            /* الجدول */
            table.table {
                font-size: 20px;
                margin-top: 20px;
                border: 1px solid #ddd;
                border-radius: 10px;
                overflow: hidden;
            }

            table thead {
                background-color: #337c3b;
                color: #fff;
            }

            table th, table td {
                padding: 12px;
                text-align: center;
            }

            table tr:nth-child(even) {
                background-color: #f8fdf9;
            }

            /* أزرار الجدول */
            table .btn-sm {
                margin: 2px;
                padding: 6px 12px;
                font-size: 15px;
                border-radius: 6px;
            }

        </style>
    @endpush
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
            <div class="container">
                <h2>رفع تقرير طبي</h2>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif


                <form action="{{ route('patient.reports.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- العنوان (اختياري) -->
                    <div class="mb-3">
                        <label for="title" class="form-label">عنوان التقرير:</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>

                    <!-- ملف التقرير -->
                    <div class="mb-3">
                        <label for="report_file" class="form-label">ملف التقرير (PDF أو صورة):</label>
                        <input type="file" name="report_file" id="report_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>

                    <button type="submit" class="btn btn-primary">رفع</button>
                </form>

                <hr>

                <h3>تقاريري المرفوعة</h3>

                @if($reports->isEmpty())
                    <p>لا يوجد تقارير.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>العنوان</th>
                            <th>تاريخ الرفع</th>
                            <th>خيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td>{{ $report->title }}</td>
                                <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $report->file_path) }}" class="btn btn-sm btn-primary" target="_blank">عرض</a>
                                    <a href="{{ asset('storage/' . $report->file_path) }}" class="btn btn-sm btn-success" download>تحميل</a>


                                    <form action="{{ route('patient.reports.destroy', $report->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا التقرير؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>



        </div>
    </div>


    @endsection

@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

@push('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap');
        /* تنسيق الحاوية */
        .member-group {
            max-width: 900px;
            background-color: #fff;
            border: 1px solid #d4edda;
            border-left: 5px solid #28a745;
            border-radius: 12px;
            padding: 20px;
            margin: 50px auto;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.1);
        }

        /* عنوان القسم */
        .member-group h5 {
            color: #28a745;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            font-family: 'Cairo', sans-serif;
            font-size: 32px;
        }

        /* تسميات الحقول */
        .member-group label {
            display: block;
            font-weight: 600;
            color: black;
            margin-bottom: 15px;
            font-family: 'Cairo', sans-serif;
            font-size: 18px;

        }

        /* حقول الإدخال */
        .member-group input.form-control,
        .member-group select.form-select,
        .member-group textarea.form-control {
            width: 90%;
            padding-right: 35px;
            font-size: 16px;
            font-family: 'Cairo', sans-serif;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .member-group input.form-control:focus,
        .member-group select.form-select:focus,
        .member-group textarea.form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 6px rgba(40, 167, 69, 0.4);
            outline: none;
        }

        /* رسائل الخطأ */
        .invalid-feedback {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
        }

        /* زر الحفظ */
        button.btn-primary {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 12px 25px;
            font-weight: 700;
            font-size: 16px;
            font-family: 'Cairo', sans-serif;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin: 0 auto;
        }

        button.btn-primary:hover {
            background-color: #218838;
        }

        /* الاستجابة للشاشات الصغيرة */
        @media (max-width: 768px) {
            .member-group .row > div {
                margin-bottom: 15px;
            }

            button.btn-primary {
                width: 100%;
            }
        }

    </style>
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
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('member.store') }}" method="POST">
                @csrf

                <div class="member-group border p-3 mb-4 rounded">
                    <h5>فرد العائلة</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>الاسم</label>
                            <input type="text" name="members[0][name]"
                                   class="form-control @error('members.0.name') is-invalid @enderror"
                                   value="{{ old('members.0.name') }}">
                            @error('members.0.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>سنة الميلاد</label>
                            <input type="number" name="members[0][birth_year]"
                                   class="form-control @error('members.0.birth_year') is-invalid @enderror"
                                   value="{{ old('members.0.birth_year') }}">
                            @error('members.0.birth_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>العلاقة</label>
                            <select name="members[0][relationship]"
                                    class="form-select @error('members.0.relationship') is-invalid @enderror">
                                <option value="">اختر</option>
                                @foreach(['أخ','أخت','ابن','ابنة','زوج','زوجة'] as $opt)
                                    <option value="{{ $opt }}" {{ old('members.0.relationship') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                            @error('members.0.relationship') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>الحالة الاجتماعية</label>
                            <select name="members[0][social_status]"
                                    class="form-select @error('members.0.social_status') is-invalid @enderror">
                                <option value="">اختر</option>
                                @foreach(['أعزب','متزوج','مطلق','أرمل'] as $opt)
                                    <option value="{{ $opt }}" {{ old('members.0.social_status') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                            @error('members.0.social_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>المستوى الأكاديمي</label>
                            <select name="members[0][academic_level]"
                                    class="form-select @error('members.0.academic_level') is-invalid @enderror">
                                <option value="">اختر</option>
                                @foreach(['ابتدائي','إعدادي','ثانوي','دبلوم','جامعي','دراسات عليا'] as $opt)
                                    <option value="{{ $opt }}" {{ old('members.0.academic_level') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                            @error('members.0.academic_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>الوضع الصحي</label>
                            <textarea name="members[0][health_status]"
                                      class="form-control @error('members.0.health_status') is-invalid @enderror">{{ old('members.0.health_status') }}</textarea>
                            @error('members.0.health_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>هل لديه إعاقة؟</label>
                            <select name="members[0][has_disability]"
                                    class="form-select @error('members.0.has_disability') is-invalid @enderror">
                                <option value="">اختر</option>
                                <option value="0" {{ old('members.0.has_disability') == '0' ? 'selected' : '' }}>لا</option>
                                <option value="1" {{ old('members.0.has_disability') == '1' ? 'selected' : '' }}>نعم</option>
                            </select>
                            @error('members.0.has_disability') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">حفظ</button>
            </form>
        </div>
    </div>


@endsection

@extends('layouts.master')

@section('page')
    @push('css')
        <style>
            body {
                font-family: 'Cairo', sans-serif;
                background-color: #f9f9f9;
                direction: rtl;
                color: #333;
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 900px;
                margin: 40px auto;
                background-color: #fff;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            }

            h2 {
                font-size: 30px;
                font-weight: 700;
                text-align: center;
                margin-bottom: 30px;
                color: #2c3e50;
            }

            form > div {
                margin-bottom: 20px;
            }

            label {
                display: block;
                margin-bottom: 8px;
                font-weight: 500;
                font-size: 25px;
            }

            select,
            textarea,
            input[type="file"],
            input[type="url"] {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 8px;
                font-size: 22px;
                font-family: 'Cairo', sans-serif;
                background-color: #fff;
                transition: border-color 0.3s;
            }

            textarea {
                resize: vertical;
            }

            input:focus,
            select:focus,
            textarea:focus {
                border-color: #4CAF50;
                outline: none;
            }

            button[type="submit"] {
                width: 100%;
                padding: 12px;
                background-color: #4CAF50;
                color: #fff;
                font-size: 20px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            button[type="submit"]:hover {
                background-color: #45a049;
            }

            div[style*="color:red"] {
                font-size: 14px;
                margin-top: 5px;
            }

            @media (max-width: 576px) {
                .container {
                    margin: 20px;
                    padding: 20px;
                }


                select,
                textarea,
                input[type="file"],
                input[type="url"] {
                    font-size: 18px;

                }

                h2 {
                    font-size: 20px;
                }

                button[type="submit"] {
                    font-size: 18px;
                    padding: 10px;
                }
            }

        </style>
    @endpush

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

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
                <img src="{{ asset('storage/' . (Auth::user()->profile_picture ?? 'defaults/profile.jpg')) }}" width="150" alt="الصورة الشخصية">
                <div class="logout-btn">
                    <a href="{{ route('logout') }}">تسجيل الخروج</a>
                </div>
            </div>

            <div class="container">
                <h2>إنشاء منشور جديد</h2>

                @if(session('success'))
                    <div style="color: green">{{ session('success') }}</div>
                @endif

                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- نوع المنشور --}}
                    <div>
                        <label>نوع المنشور:</label>
                        <select id="type-select" name="type" required>
                            <option value="news" {{ old('type', 'news') == 'news' ? 'selected' : '' }}>خبر</option>
                            <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>فعالية</option>
                            <option value="donation" {{ old('type') == 'donation' ? 'selected' : '' }}>تبرع</option>

                        </select>
                        @error('type')
                        <div style="color:red;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- المحتوى النصي --}}
                    <div>
                        <label>المحتوى:</label>
                        <textarea name="post" rows="5" required>{{ old('post') }}</textarea>
                        @error('post')
                        <div style="color:red;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- الحقول التي تظهر فقط إذا لم يكن النوع "خبر" --}}
                    <div id="media-fields" style="display: none;">

                        {{-- الصورة --}}
                        <div>
                            <label>صورة (اختياري):</label>
                            <input type="file" name="photo">
                            @error('photo')
                            <div style="color:red;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- الفيديو --}}
                        <div>
                            <label>فيديو (اختياري):</label>
                            <input type="file" name="video">
                            @error('video')
                            <div style="color:red;">{{ $message }}</div>
                            @enderror

                            <br>أو رابط فيديو:
                            <input type="url" name="video_link" value="{{ old('video_link') }}">
                            @error('video_link')
                            <div style="color:red;">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div>
                        <button type="submit">نشر</button>
                    </div>
                </form>
            </div>
         </div>
    </div>


    {{-- سكريبت إظهار وإخفاء الحقول --}}
    <script>
        function toggleMediaFields() {
            const type = document.getElementById('type-select').value;
            const mediaFields = document.getElementById('media-fields');

            if (type === 'news') {
                mediaFields.style.display = 'none';
            } else {
                mediaFields.style.display = 'block';
            }
        }

        document.getElementById('type-select').addEventListener('change', toggleMediaFields);

    </script>
@endsection


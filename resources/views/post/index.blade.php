@php use Illuminate\Support\Str; @endphp
@extends('layouts.master')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@section('page')

    @push('css')
        <style>
            .dashboard-container {
                display: flex;
                min-height: 100vh;
                flex-direction: row;
            }

            .sidebar {
                width: 250px;
                background-color: #3d5571;
                color: #fff;
                padding: 20px;
                box-sizing: border-box;
            }

            .sidebar h3 {
                margin-bottom: 20px;
                font-size: 20px;
                border-bottom: 1px solid #7f8c8d;
                padding-bottom: 10px;
            }

            .sidebar a {
                display: block;
                color: #ecf0f1;
                padding: 10px;
                margin: 5px 0;
                text-decoration: none;
                border-radius: 5px;
                transition: background 0.3s;
                white-space: normal;
                word-break: break-word;
            }

            .sidebar a:hover {
                background-color: #34495e;
            }

            .main-content {
                flex: 1;
                padding: 20px;
                background-color: #ecf0f1;
                box-sizing: border-box;
            }

            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background-color: #fff;
                padding: 15px 20px;
                border-bottom: 1px solid #ccc;
                flex-wrap: wrap;
                box-sizing: border-box;
            }

            .header .user-name {
                font-weight: bold;
                margin-bottom: 10px;
            }

            .header .logout-btn a {
                display: inline-block;
                padding: 8px 16px;
                background-color: #bf273a;
                color: #fff;
                border-radius: 6px;
                text-decoration: none;
                font-weight: bold;
                transition: background-color 0.3s ease;
            }

            .header .logout-btn a:hover {
                background-color: #da3847;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .dashboard-container {
                    flex-direction: column;
                }

                .sidebar {
                    width: 100%;
                    text-align: center;
                    padding: 10px 0;
                }

                .sidebar a {
                    display: block; /* احتفظ بـ block */
                    margin: 5px 0;
                    text-align: center;
                }

                .main-content {
                    padding: 15px;
                }
            }

            @media (max-width: 480px) {
                .header {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .header .logout-btn a {
                    width: 100%;
                    text-align: center;
                    margin-top: 10px;
                }

                .sidebar a {
                    display: block;
                    width: 100%;
                }
            }
            .container {
                max-width: 900px;
                margin: 40px auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                font-family: 'Cairo', sans-serif;
                direction: rtl;
                color: #333;
            }

            .container h1 {
                font-size: 36px;
                font-weight: bold;
                text-align: center;
                margin-bottom: 30px;
                color: #2c3e50;
            }

            .container > a {
                display: inline-block;
                margin-bottom: 25px;
                padding: 10px 20px;
                background-color: #4caf50;
                color: white;
                border-radius: 8px;
                font-size: 20px;
                text-decoration: none;
                transition: background-color 0.3s;
            }

            .container > a:hover {
                background-color: #45a049;
            }

            .post-card {
                border: 1px solid #ddd;
                padding: 20px;
                margin-bottom: 25px;
                border-radius: 12px;
                background-color: #fdfdfd;
                box-shadow: 0 1px 5px rgba(0,0,0,0.05);
            }

            .post-card img,
            .post-card video,
            .post-card iframe {
                max-width: 100%;
                width: 250px;
                height: auto;
                max-height: 200px;
                object-fit: cover;
                border-radius: 10px;
                display: block;
                margin: 10px auto;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            }


            .post-card h3 {
                font-size: 28px;
                color: #4caf50;
                margin-bottom: 15px;
                font-weight: bold;
            }
            button.delete-btn {
                background-color: #bf273a; /* أحمر */
                border: none;
                color: white;
                padding: 8px 16px;
                font-size: 18px;
                border-radius: 8px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            button.delete-btn:hover {
                background-color: #da3847; /* أحمر أفتح عند المرور */
            }


            .post-card p {
                font-size: 22px;
                line-height: 1.5;
                margin-bottom: 15px;
                color: #444;
            }

            .post-card img,
            .post-card video,
            .post-card iframe {
                max-width: 100%;
                border-radius: 8px;
                margin: 15px 0;
            }

            .post-card p:last-child {
                color: gray;
                font-size: 16px;
                margin-top: 15px;
            }

            .post-card div {
                margin-top: 15px;
            }

            .post-card a,
            .post-card button {
                font-size: 18px;
                margin-right: 12px;
                color: #4caf50;
                text-decoration: none;
                cursor: pointer;
            }

            .post-card a:hover,
            .post-card button:hover {
                text-decoration: underline;
            }

            .inline {
                display: inline;
            }

            button {
                background-color: #4caf50;
                border: none;
                color: white;
                padding: 8px 16px;
                font-size: 18px;
                border-radius: 8px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            button:hover {
                background-color: #45a049;
            }

            .bg-red-100 {
                background-color: #ffe5e5;
            }

            .text-red-700 {
                color: #b71c1c;
                font-size: 22px;
                font-weight: bold;
            }

            .text-blue-600 {
                color: #1565c0;
                font-size: 18px;
                font-weight: 600;
                text-decoration: underline;
                background: none;
                border: none;
                cursor: pointer;
                padding: 0;
            }

            @media (max-width: 768px) {
                .container {
                    padding: 15px;
                    margin: 20px 10px;
                }

                .container h1 {
                    font-size: 28px;
                }

                .container > a {
                    font-size: 18px;
                    padding: 8px 15px;
                }

                .post-card h3 {
                    font-size: 24px;
                }

                .post-card p {
                    font-size: 18px;
                }

                button, .post-card a {
                    font-size: 16px;
                }
            }

            @media (max-width: 480px) {
                .container {
                    margin: 15px 5px;
                    padding: 10px;
                }

                .container h1 {
                    font-size: 24px;
                }

                .post-card h3 {
                    font-size: 20px;
                }

                .post-card p {
                    font-size: 16px;
                }

                button, .post-card a {
                    font-size: 14px;
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
                <h1>جميع المنشورات</h1>

                <a href="{{ route('posts.index') }}">إنشاء منشور</a>

                @foreach($posts as $post)
                    <div class="post-card">
                        <h3>النوع:
                            @if($post->type == 'news') خبر
                            @elseif($post->type == 'event') فعالية
                            @elseif($post->type == 'donation') حالة تبرع
                            @endif
                        </h3>

                        <p>{{ $post->post }}</p>

                        {{-- عرض الصورة إن وجدت --}}
                        @if($post->photo)
                            <img src="{{ asset('storage/' . $post->photo) }}" alt="الصورة">
                        @endif

                        {{-- عرض الفيديو إن وجد --}}
                        @if($post->video)
                            @if(Str::contains($post->video, 'youtube.com') || Str::contains($post->video, 'youtu.be'))
                                @php
                                    $embedLink = Str::replace('watch?v=', 'embed/', $post->video);
                                    $embedLink = Str::replace('youtu.be/', 'www.youtube.com/embed/', $embedLink);
                                @endphp
                                <iframe width="100%" height="250" src="{{ $embedLink }}" frameborder="0" allowfullscreen></iframe>
                            @else
                                <video width="100%" controls>
                                    <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                                    المتصفح لا يدعم تشغيل الفيديو.
                                </video>
                            @endif
                        @endif

                        <p>تاريخ النشر: {{ $post->created_at->format('Y-m-d H:i') }}</p>

                        <div>
                            <a href="{{ route('posts.edit', $post->id) }}">تعديل</a> |

                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                            </form>

                            <a href="{{ route('posts.toggleActive', $post->id) }}">
                                {{ $post->active ? 'تعطيل' : 'تفعيل' }}
                            </a>
                        </div>
                    </div>

{{--                    @if($post->active == '0')--}}
{{--                        <div class="bg-red-100 text-red-700 p-4 rounded my-4">--}}
{{--                            هذا المنشور <strong>معطل</strong>.--}}
{{--                            <form action="{{ route('posts.toggleActive', $post->id) }}" method="POST" class="inline">--}}
{{--                                @csrf--}}
{{--                                @method('PATCH')--}}
{{--                                <button type="submit" class="text-blue-600 underline ml-2">إلغاء التعطيل</button>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                @endforeach
            </div>
        </div>
    </div>
@endsection

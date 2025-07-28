@php use Illuminate\Support\Str; @endphp
@extends('layouts.master')


@push('css')
    <link rel="stylesheet" href="{{ asset('/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/achievement.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

@endpush

@section('title', '  الإنجازات ')

@section('page')
    <style>
        .achievement-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            color: #333;
        }

        .achievement-container h2 {
            font-size: 32px;
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
            font-weight: bold;
        }

        .achievement-card {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            font-size: 20px;
        }

        .achievement-card strong {
            color: #4caf50;
        }

        .achievement-card img,
        .achievement-card video,
        .achievement-card iframe {
            max-width: 100%;
            border-radius: 8px;
            margin-top: 15px;
        }

        .achievement-card iframe,
        .achievement-card video {
            height: 250px;
        }

        @media (max-width: 768px) {
            .achievement-card {
                font-size: 18px;
                padding: 15px;
            }

            .achievement-card iframe,
            .achievement-card video {
                height: 200px;
            }
        }

        @media (max-width: 480px) {
            .achievement-container {
                padding: 10px;
            }

            .achievement-card {
                font-size: 16px;
            }

            .achievement-card iframe,
            .achievement-card video {
                height: 180px;
            }
        }
    </style>
    <!-- روابط اللغة -->
    <div class="language-switch">
        <a href="/locale/ar">العربية</a>
        <span class="divider">|</span>
        <a href="/locale/en">English</a>
    </div>

    {{--شريط التنقل--}}
    <nav class="nav">
        <div class="logo-section">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo.jpg') }}" alt="شعار الجمعية" class="logo" />
                <span class="logo-text">جمعية الرحمة الخيرية للتأهيل</span>
            </a>
        </div>

        <!-- القائمة الجانبية (sidebar) -->
        <ul class="sidebar">
            <li class="close-btn" onclick="hideSidebar()">
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#1f1f1f">
                        <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                    </svg>
                </a>
            </li>
            <li><a href="{{url('/')}}">الرئيسية</a></li>
            <li><a href="{{url('/about')}}">من نحن </a></li>
            <li><a href="{{url('/support')}}">الخدمات</a></li>
            <li><a href="{{url('/achievement')}}">الفعاليات</a></li>
            <li><a href="{{url('/contact')}}">تواصل معنا</a></li>
        </ul>

        <!-- قائمة التنقل الرئيسية -->
        <ul class="main-nav">
            <li><a class="hideOnMobile" href="{{url('/')}}">الرئيسية</a></li>
            <li><a class="hideOnMobile" href="{{url('/about')}}">من نحن </a></li>
            <li><a class="hideOnMobile" href="{{url('/support')}}">الخدمات</a></li>
            <li><a class="hideOnMobile" href="{{url('/achievement')}}">الفعاليات</a></li>
            <li><a class="hideOnMobile" href="{{url('/contact')}}">تواصل معنا</a></li>
            <li class="menu-button" onclick="showSidebar()">
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#1f1f1f">
                        <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/>
                    </svg>
                </a>
            </li>
        </ul>
        <!-- الأزرار -->
        <div class="nav-buttons">
            <a href="{{ route('log_form') }}" class="btn login">
                <i class="fas fa-sign-in-alt"></i>
                <span>تسجيل الدخول</span>
            </a>
            <a href="#" class="btn donate">
                <i class="fas fa-hand-holding-heart"></i>
                <span>تبرع الآن</span>
            </a>
        </div>
    </nav>
    {{--End Navbar--}}


    <div class="achievement-container">
        <h2>الإنجازات</h2>

        @forelse ($achievements as $post)
            <div class="achievement-card">
                <p><strong>المحتوى:</strong> {{ $post->post }}</p>

                @if ($post->photo)
                    <div>
                        <img src="{{ asset('storage/' . $post->photo) }}" alt="صورة الإنجاز">
                    </div>
                @endif

                @if ($post->video)
                    @if(Str::contains($post->video, 'youtube.com') || Str::contains($post->video, 'youtu.be'))
                        @php
                            $embedLink = $post->video;

                            // تحويل رابط YouTube إلى صيغة embed
                            if(Str::contains($embedLink, 'watch?v=')) {
                                $embedLink = Str::replace('watch?v=', 'embed/', $embedLink);
                            }

                            if(Str::contains($embedLink, 'youtu.be/')) {
                                $videoId = Str::after($embedLink, 'youtu.be/');
                                $embedLink = 'https://www.youtube.com/embed/' . $videoId;
                            }
                        @endphp

                        <div>
                            <iframe width="100%" height="250" src="{{ $embedLink }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @else
                        <div>
                            <video controls width="100%">
                                <source src="{{ asset('storage/' . $post->video) }}">
                            </video>
                        </div>
                    @endif
                @endif

            </div>
        @empty
            <p class="text-center">لا توجد إنجازات حالياً.</p>
        @endforelse
    </div>


    <!-- الفوتر -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <h3>تواصل معنا</h3>
                <p>البريد الإلكتروني:
                    <a class="email" href="mailto:alrahma.society2006@gmail.com">
                        alrahma.society2006@gmail.com
                    </a>
                </p>
                <p>جوال: 0599830516 | تلفاكس: 2582110-02</p>
                <p>العنوان: بيت أولا - الخليل / خلف بلدية بيت أولا</p>
                <p>رقم الحساب: 10048249<br> البنك الوطني - فرع الخليل</p>
            </div>

            <div class="footer-content">
                <h3>أقسام الموقع</h3>
                <ul class="list">
                    <li><a href="{{url('/')}}">الرئيسية</a></li>
                    <li><a href="{{url('/about')}}"> من نحن </a></li>
                    <li><a href="{{url('/support')}}">الخدمات</a></li>
                    <li><a href="{{url('/achievement')}}">الفعاليات</a></li>
                    <li><a href="{{url('/contact')}}">تواصل معنا</a></li>
                    <li><a href="{{url('/donations')}}">تبرع الآن</a></li>
                </ul>
            </div>

            <div class="footer-content">
                <h3>تابعنا</h3>
                <ul class="social-icons">
                    <li>
                        <a href="https://www.facebook.com/جمعية-الرحمة-الخيرية-للتأهيل" target="_blank">
                            <i class="fab fa-facebook fa-2x"></i>
                            <span class="facebook-name">جمعية الرحمة الخيرية للتأهيل</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <div class="bottom-bar">
        <p>&copy; 2025 جمعية الرحمة الخيرية للتأهيل. جميع الحقوق محفوظة.</p>
    </div>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
            src="https://connect.facebook.net/ar_AR/sdk.js#xfbml=1&version=v19.0"
            nonce="yourNonceValue"></script>

    <script src="{{ asset('js/welcome.js') }}"></script>

@endsection

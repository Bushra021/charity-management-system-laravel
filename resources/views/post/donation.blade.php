@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('/css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/normalize.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

@endpush

@section('page')

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
            <li><a href="{{route('achievement.index')}}">الفعاليات</a></li>
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

            <a href="{{route('donations.index')}}" class="btn donate">
                <i class="fas fa-hand-holding-heart"></i>
                <span>تبرع الآن</span>
            </a>
        </div>

    </nav>



    @push('css')
        <style>

            .main-title {
                font-family: 'Cairo', sans-serif;
                font-size: 35px;
                font-weight: bold;
                color: #1e5631;
                border-bottom: 3px solid #a3d9a5;
                display: inline-block;
                padding-bottom: 8px;
                margin-top: 35px;

            }

            .donation-card {
                background-color: #fff;
                border-radius: 12px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
                padding: 24px;
                width: 100%;
                max-width: 900px;
                align-items: center;
                transition: 0.3s ease;
                margin: 40px auto;
            }

            .donation-card:hover {
                box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12);
            }

            .donation-title {
                text-align: center;
                font-size: 25px;
                font-weight: 700;
                color: #207f44;
                margin-bottom: 16px;
                font-family: 'Cairo', sans-serif;
            }

            .donation-text {
                text-align: center;
                color: #444;
                line-height: 1.7;
                font-size: 20px;
                font-weight: 600;
                font-family: 'Cairo', sans-serif;
            }

            .donation-image {
                overflow: hidden;
                border-radius: 1rem;
                margin: 0 auto;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 200px;
                height: 200px;
                max-width: 100%;

            }

            .donation-photo {
                margin-top: 25px;
                width: 200px;
                height: 200px;
                max-width: 100%;
                max-height: 220px;
                object-fit: cover;
                border-radius: 10%;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            }

            .account-info {
                font-family: 'Cairo', sans-serif;
                margin-top: 25px;
                background-color: #f7f7f7;
                padding: 12px;
                border-radius: 10px;
                text-align: center;
                font-size: 20px;
                color: #333;
            }
        </style>
    @endpush

    {{-- عنوان الصفحة --}}
    <div class="text-center my-8">
        <h1 class="main-title">حملات التبرع</h1>
    </div>

    {{-- الحاوية العامة --}}
    <div class="flex flex-col items-center justify-center gap-10 px-4 mb-10">
        @foreach($donations as $donation)
            <div class="donation-card">

                {{-- عنوان الحملة --}}
                <h2 class="donation-title">
                    {{ $donation->title ?? 'عنوان الحملة' }}
                </h2>

                {{-- نص الحملة بدون زر قراءة المزيد --}}
                <div class="donation-text">
                    <p>{{ $donation->post }}</p>
                </div>



                {{-- صورة التبرع --}}
                @if($donation->photo)
                    <div class="donation-image">
                        <img src="{{ asset('storage/' . $donation->photo) }}" alt="صورة الحملة" class="donation-photo ">
                    </div>
                @endif



                {{-- معلومات الحساب --}}
                <div class="account-info">
                    <p><strong>رقم الحساب البنكي:</strong> 10048249</p>
                    <p><strong>رقم جوال الجمعية:</strong> 0599830516 </p>
                </div>
            </div>
        @endforeach
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
                    <li><a href="{{route('donations.index')}}">تبرع الآن</a></li>
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


    <script src="{{ asset('js/welcome.js') }}"></script>
    <script src="https://unpkg.com/scrollreveal"></script>

@endsection

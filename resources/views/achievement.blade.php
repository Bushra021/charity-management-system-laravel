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


    <div class="achievements-container">
        <h1 class="page-title">إنجازات الجمعية</h1>

        <div class="cards">
            <!-- مشروع الزراعة -->
            <div class="card">
                <img src="{{ asset('images/agriculture.jpg') }}" alt="مشروع الزراعة">
                <h3>مشروع الزراعة</h3>
                <p>ساهم المشروع في تمكين عدد من الأسر من زراعة أراضيهم وتحقيق الاكتفاء الذاتي.</p>
            </div>

            <!-- مشروع ترميم المنازل -->
            <div class="card">
                <img src="{{ asset('images/renovation.jpg') }}" alt="مشروع ترميم المنازل">
                <h3>مشروع ترميم المنازل</h3>
                <p>تم ترميم العديد من المنازل غير الصالحة للسكن لتوفير بيئة آمنة للأسر المحتاجة.</p>
            </div>

            <!-- مشروع الطاقة البديلة -->
            <div class="card">
                <img src="{{ asset('images/solar.jpg') }}" alt="مشروع الطاقة البديلة">
                <h3>مشروع الطاقة البديلة</h3>
                <p>زُوِّدت عدد من المنازل بأنظمة الطاقة الشمسية لتقليل الاعتماد على الكهرباء التقليدية.</p>
            </div>
        </div>
    </div>

    <div class="success-stories">
        <h2 class="section-title">قصص النجاح</h2>

        <!-- الفيديو الأول -->
        <div class="video-item">
            <h4>تحقيق الاكتفاء الذاتي لعائلة عبر مشروع الزراعة</h4>
            <div class="fb-video"
                 data-href="https://www.facebook.com/[PAGE]/videos/[VIDEO-ID]/"
                 data-width="500"
                 data-allowfullscreen="true"
                 data-autoplay="false"
                 data-show-text="false">
            </div>
        </div>

        <!-- فيديو آخر -->
        <div class="video-item">
            <h4>ترميم منزل وتأمين حياة كريمة</h4>
            <div class="fb-video"
                 data-href="https://www.facebook.com/[PAGE]/videos/[VIDEO-ID]/"
                 data-width="500"
                 data-allowfullscreen="true"
                 data-autoplay="false"
                 data-show-text="false">
            </div>
        </div>

        <!-- زر المزيد -->
        <div class="more-videos">
            <a href="https://www.facebook.com/[PAGE]/videos" target="_blank">رؤية المزيد من الفيديوهات</a>
        </div>
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
                    <li><a href="{{url('/donate')}}">تبرع الآن</a></li>
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

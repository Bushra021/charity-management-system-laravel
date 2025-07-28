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

    {{--شريط الأخباار --}}
    @if($newsPosts->count())
        <div style="background-color: #fffae6; border-bottom: 1px solid #f0e68c; padding: 10px;">
            <div style="display: flex; align-items: center;">
                <strong style="margin-right: 15px; color: #b58900;">الأخبار:</strong>
                <marquee direction="right" scrollamount="4" style="color: #333; font-weight: bold;">
                    @foreach($newsPosts as $news)
                        <span style="margin-left: 50px;">
                        📰 {{ $news->post }}
                    </span>
                    @endforeach
                </marquee>
            </div>
        </div>
    @endif

    {{--البانر--}}
    <div id="quoteSlider" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

            <!-- الشريحة الأولى -->
            <div class="carousel-item active">
                <div class="banner-slide" style="background-image: url('images/banner1.jpg');">

                </div>
            </div>

            <!-- الشريحة الثانية -->
            <div class="carousel-item">
                <div class="banner-slide" style="background-image: url('images/activity7.jpg');">
                    <div class="banner-caption">
                        <p>الرحمة هي أساس العمل الإنساني وركيزة خدماتنا في الجمعية</p>
                    </div>
                </div>
            </div>

            <!-- الشريحة الثالثة -->
            <div class="carousel-item">
                <div class="banner-slide" style="background-image: url('images/children2.jpg');">
                    <div class="banner-caption">
                        <p>نحن نؤمن بقدرات ذوي الإعاقة ونحرص على تطويرها بكل السبل</p>
                    </div>
                </div>
            </div>

            <!-- الشريحة الرابعة -->
            <div class="carousel-item">
                <div class="banner-slide" style="background-image: url('images/banner.jpg');">
                    <div class="banner-caption">
                        <p>كلنا شركاء في تحقيق رؤية الجمعية نحو مجتمع أكثر شمولاً</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- أزرار التنقل -->
        <button class="carousel-control-prev" type="button" data-bs-target="#quoteSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">السابق</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#quoteSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">التالي</span>
        </button>

    </div>
    <!-- مؤشرات الشرائح -->
    <div class="custom-carousel-indicators">
        <button type="button" data-bs-target="#quoteSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="الشريحة 1"></button>
        <button type="button" data-bs-target="#quoteSlider" data-bs-slide-to="1" ></button>
        <button type="button" data-bs-target="#quoteSlider" data-bs-slide-to="2" ></button>
        <button type="button" data-bs-target="#quoteSlider" data-bs-slide-to="3" ></button>
    </div>

    {{--نهاية البانر--}}

    <div class="container my-5 vision-mission-values">
        <div class="row ">
            <div class="col-md-12">


                <!-- الرؤية -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body bg-light border-end border-success border-5 rounded">
                        <h5 class="card-title text-success fw-bold"><i class="bi bi-eye"></i> الرؤية</h5>
                        <p class="card-text">أن ينعم ذوي الإعاقة بحياة ذات جودة مستقرة وممكنة</p>
                    </div>
                </div>

                <!-- الرسالة -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body bg-light border-end border-secondary border-5 rounded">
                        <h5 class="card-title text-dark fw-bold"><i class="bi bi-pencil-square"></i> الرسالة</h5>
                        <p class="card-text">
                            هذه الرسالة تعبر عن التزام الجمعية بتقديم الدعم والرعاية للأشخاص ذوي الإعاقة وتعكس رغبتها في تحقيق التمكين والتكامل في المجتمع المحلي
                            من خلال عقد الشراكات، وتفعيل التطوع، وتمكين الكادر، وتحقيق الاستدامة.
                        </p>
                    </div>
                </div>

                <!-- القيم -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-light border-end border-warning border-5 rounded">
                        <h5 class="card-title text-warning fw-bold"><i class="bi bi-star-fill"></i> القيم</h5>
                        <div class="row row-cols-2 row-cols-md-4 g-2 mt-3 text-center">
                            <div class="col"><div class="bg-white p-2 rounded shadow-sm fw-bold text-success">الجودة<br><small>Quality</small></div></div>
                            <div class="col"><div class="bg-white p-2 rounded shadow-sm fw-bold text-secondary">الشفافية<br><small>Transparency</small></div></div>
                            <div class="col"><div class="bg-white p-2 rounded shadow-sm fw-bold text-warning">التميّز<br><small>Excellence</small></div></div>
                            <div class="col"><div class="bg-white p-2 rounded shadow-sm fw-bold text-muted">الأمانة<br><small>Honesty</small></div></div>
                            <div class="col"><div class="bg-white p-2 rounded shadow-sm fw-bold text-info">الموثوقية<br><small>Credibility</small></div></div>
                            <div class="col"><div class="bg-white p-2 rounded shadow-sm fw-bold text-danger">الخصوصية<br><small>Privacy</small></div></div>
                            <div class="col"><div class="bg-white p-2 rounded shadow-sm fw-bold text-dark">روح الفريق<br><small>Teamwork</small></div></div>
                            <div class="col"><div class="bg-white p-2 rounded shadow-sm fw-bold text-primary">الاحترام<br><small>Respect</small></div></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- الخدمات -->
    <section class="simple-accordion">
        <h2 class="section">الخدمات</h2>
        <div class="service-cards">
            <div class="card">
                <i class="fas fa-wheelchair fa-2x"></i>
                <h3>خدمة التأهيل</h3>
                <p> برامج خاصة لتأهيل ذوي الإعاقة الحركية والذهنية. برنامج التأهيل المهني </p>
            </div>
            <div class="card">
                <i class="fas fa-heartbeat fa-2x"></i>
                <h3> الدعم النفسي</h3>
                <p>جلسات دعم نفسي فردية وجماعية لتحسين الصحة النفسية.</p>
            </div>
            <div class="card">
                <i class="fas fa-users fa-2x"></i>
                <h3>خدمات مجتمعية</h3>
                <p>ورش توعية وتثقيف لأهالي ذوي الإعاقة لتعزيز الدمج المجتمعي.</p>
            </div>
            <div class="card">
                <i class="fas fa-house-medical fa-2x"></i>
                <h3>خدمات طبية</h3>
                <p> العلاج الفيزيائي والوظيفي, علاج مشاكل النطق والسمع.  التربية الخاصة.الرعاية النهارية .صعوبات التعلم .</p>
            </div>

        </div>
    </section>

    {{-- الأسئلة الشائعة --}}
    <section class="simple-accordion">
        <h2 class="section-title">الأسئلة الشائعة</h2>

        <div class="accordion-item">
            <button class="accordion-toggle">
                1. ما هي الفئة التي تخدمها الجمعية؟
                <span class="arrow">⌄</span>
            </button>
            <div class="accordion-content">
                جميع الأشخاص ذوي الإعاقة المختلفة في منطقة شمال غرب الخليل ذكوراً وإناثاً.
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-toggle">
                2. كيف يمكنني التبرع للجمعية؟
                <span class="arrow">⌄</span>
            </button>
            <div class="accordion-content">
                يمكنك التبرع للجمعية من خلال البنك الوطني فرع الخليل .أو من خلال هذا الرابط:
                <a href="{{route('donations.index')}}">تبرع الآن</a>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-toggle">
                3. هل خدمات الجمعية مجانية؟
                <span class="arrow">⌄</span>
            </button>
            <div class="accordion-content">
                نعم، كافة خدمات الجمعية تُقدم بشكل مجاني بالكامل للمستفيدين.
            </div>
        </div>
        <div class="accordion-item">
            <button class="accordion-toggle">
                4. ما أنواع الخدمات التي تقدمها الجمعية؟
                <span class="arrow">⌄</span>
            </button>
            <div class="accordion-content">
                تقدم الجمعية خدمات تعليمية، تأهيلية، نفسية، طبية واجتماعية للأشخاص ذوي الإعاقة، حسب احتياجات كل حالة.
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-toggle">
                5. هل يمكنني التطوع في الجمعية؟
                <span class="arrow">⌄</span>
            </button>
            <div class="accordion-content">
                نعم، الجمعية ترحب بالمتطوعين في مختلف المجالات. يمكنكم التواصل معنا من خلال هذا الرابط
                <a href="{{url('/contact')}}">تواصل معنا</a></div>
        </div>

        <div class="accordion-item">
            <button class="accordion-toggle">
                6. ما هي ساعات عمل الجمعية؟
                <span class="arrow">⌄</span>
            </button>
            <div class="accordion-content">
                ساعات الدوام: من الساعة 8:00 صباحاً حتى 2:00 ظهراً، من السبت إلى الخميس.
            </div>
        </div>

    </section>

    <!-- الخريطة  -->
    <section id="contact" class="contact">
        <div class="container">
            <h2 class="section-title"> مقر الجمعية</h2>



            <!-- الخريطة -->
            <div class="map-wrapper">
                <iframe
                    class="map"
                    src="https://www.google.com/maps?q=بيت%20أولا%20خلف%20البلدية%20الخليل%20فلسطين&z=15&output=embed"
                    width="100%"
                    height="100%"
                    frameborder="0"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    {{--زر الرجوع للاعلى--}}
    <button id="backToTop" aria-label="الرجوع للأعلى"> ↑ </button>


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

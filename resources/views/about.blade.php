@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/about.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

@endpush

@section('title', '  من نحن ')

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

    {{--    نبذة عن الجمعية--}}
    <section id="about" dir="rtl" class="about-section">
        <div class="about-container">
            <h2 class="about-title">نبذة عن الجمعية</h2>


            <div class="about-image-wrapper">
                <img src="../images/person-wheelchair.jpg" alt="صورة الجمعية" class="about-main-image">
            </div>

            <h3 class="about-subtitle">جمعية الرحمة في سطور ...</h3>
            <p class="about-paragraph">
                تأسست الجمعية عام 2006 في بلدة بيت أولا بمحافظة الخليل، وتعمل كمؤسسة أهلية غير ربحية تهدف إلى تحسين جودة حياة الأشخاص ذوي الإعاقة ودمجهم في المجتمع.

                وتسعى لتأمين احتياجاتهم وتأهيلهم
                وتعمل على دمجهم بفعالية في المجتمع المحلي بالاستعانة بكوادر متخصصة من خلال توفير الدعم اللازم والفرص التعليمية والتدريبية .
            </p>

            <h4 class="about-vision-title">هدفنا...</h4>
            <p class="about-paragraph">
                نطمح لمجتمع واعٍ يُحترم فيه حقوق ذوي الإعاقة، يحتضن ذوي الإعاقة ويوفر لهم بيئة مدمجة وداعمة،
                ويمكنهم من المشاركة الكاملة والمتساوية في كافة جوانب الحياة.
            </p>

            <section class="about-details-section">
                <div class="about-wrapper">

                    <!-- النصوص -->
                    <div class="about-details-container">
                        <!-- الرؤية -->
                        <div class="about-detail-block">
                            <i class="fas fa-sun about-icon" aria-hidden="true"></i>
                            <div>
                                <h3 class="about-detail-title">الرؤية:</h3>
                                <p class="about-detail-text">أن ينعم الأشخاص ذوو الإعاقة بحياة ذات جودة مستقرة ومحفزة.</p>
                            </div>
                        </div>

                        <!-- الرسالة -->
                        <div class="about-detail-block">

                            <i class="fas fa-project-diagram about-icon" aria-hidden="true"></i>
                            <div>
                                <h3 class="about-detail-title">الرسالة:</h3>
                                <p class="about-detail-text">مساندة ذوي الإعاقة في الحصول على احتياجاتهم وتحقيق رضا الداعمين، وعقد الشراكات المجتمعية، وتوفير الفرص التطوعية، وتطوير العمل الإداري، والاستخدام الأمثل لموارد الجمعية.</p>
                            </div>
                        </div>

                        <!-- القيم -->
                        <div class="about-detail-block">
                            <i class="fas fa-gem about-icon" aria-hidden="true"></i>
                            <div>
                                <h3 class="about-detail-title">القيم:</h3>
                                <p class="about-detail-text">الجودة، الشفافية، التميز، الأمانة، الموضوعية، الخصوصية، روح الفريق، الاحترام.</p>
                            </div>
                        </div>
                    </div>

                    <!-- الصورة -->
                    <div class="about-image">
                        <img src="images/about1.jpg" alt="من نحن">
                    </div>

                </div>
            </section>

            <!-- الأهداف العامة -->
            <section class="about-details-section">
                <div class="about-wrapper-goals">

                    <!-- الصورة -->
                    <div class="about-image">
                        <img src="images/about.jpg" alt="من نحن1">
                    </div>

                    <!-- النصوص -->
                    <div class="about-details-container">
                        <div class="about-detail-block">
                            <i class="fas fa-bullseye about-icon" aria-hidden="true"></i>
                            <div>
                                <h3 class="about-detail-title0">الأهداف العامة:</h3>
                                <ul class="about-detail-text">
                                    <li>رعاية الأشخاص ذوي الإعاقة في منطقة شمال غرب الخليل.</li>
                                    <li>توفير جميع الاحتياجات الخاصة للأشخاص ذوي الإعاقة.</li>
                                    <li>تأهيل الأشخاص ودمجهم في المجتمع المحلي.</li>
                                    <li>نشر الوعي لدى الأشخاص ذوي الإعاقة وعائلاتهم بحقوقهم.</li>
                                    <li>المناصرة والتأثير على السياسات والتشريعات.</li>
                                    <li>تقديم خدمات التأهيل المهني والاجتماعي والنفسي.</li>
                                    <li>التشبيك مع النقابات وتنظيم حملات إعلامية.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </section>


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


    <script src="{{ asset('js/welcome.js') }}"></script>

@endsection

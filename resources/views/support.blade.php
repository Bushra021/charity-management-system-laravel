@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/support.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
@endpush


@section('title', 'الخدمات')

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
            <a href="{{route('donations.index')}}" class="btn donate">
                <i class="fas fa-hand-holding-heart"></i>
                <span>تبرع الآن</span>
            </a>
        </div>
    </nav>

    <section class="simple-accordion">
        <h2 class="section-title">خدماتنا</h2>

        <div class="accordion-item">
            <button class="accordion-toggle">
                1. توفير أدوات المساعدة
                <span class="arrow">⌄</span>
            </button>
            <div class="accordion-content">
                تقدم الجمعية للمستفيدين مجموعة متنوعة من الأدوات
                كراسي متحركة بأنواعها المختلفة ,مثل:العكازات
                ووكرات (Walkers), الأسرْة الطبية والفرشات الهوائية.
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-toggle">
                2.  توفير  الأجهزة الطبية
                <span class="arrow">⌄</span>
            </button>
            <div class="accordion-content">

                <p>مثل:
                    أجهزة الأكسجين,
                    أجهزة شفط البلغم,
                    سماعات طبية,
                    أطراف صناعية,
                    بوت طبي,
                    ماكنة برل (جهاز للمكفوفين).
                </p>
                <br>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-toggle">
                3. تقديم الخدمات التأهيلية
                <span class="arrow">⌄</span>
            </button>
            <div class="accordion-content">
                نساعد في تقديم العديد من الخدمات التأهيلية والتي تتمثل في :
                ,العلاج الفيزيائي ,العلاج الوظيفي
                ,العلاج النطقي (تأهيل نطقي),علاج مشاكل النطق,
                علاج مشاكل السمع ,صعوبات التعلم.
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-toggle">
                4. تقديم خدمات تربوية
                <span class="arrow">⌄</span>
            </button>
            <div class="accordion-content">
                مثل :  التربية الخاصة,
                الإرشاد النفسي والتربوي,
                الرعاية النهارية.
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-toggle">
                5.  المتابعة المستمرة والدعم
                <span class="arrow">⌄</span>
            </button>
            <div class="accordion-content">
                وتتمثل في المتابعة منزلية,
                والمساعدات اجتماعية,
                وخدمة الطرود الغذائية.
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-toggle">
                6.  تعديلات منزلية
                <span class="arrow">⌄</span>
            </button>
            <div class="accordion-content">
                ويتمثل في :تعديل الحمام,
                تعديل المطبخ,
                تعديل الدرج,
                تعديل داخل البيت,
                تعديل خارج البيت.
            </div>
        </div>
        <div class="accordion-item">
            <button class="accordion-toggle">
                7.  تعبئة بيانات ذوي الإعاقة
                <span class="arrow">⌄</span>
            </button>
            <div class="accordion-content">
                جمع وتنظيم بيانات المستفيدين لتسهيل تقديم الخدمات المناسبة.
            </div>
        </div>

    </section>

    {{--صور توضيحية للخدمات--}}
    <section class="tools-section" dir="rtl">
        <h2 class="tools-title">أدوات وخدمات الجمعية</h2>
        <div class="tools-container">

            <!-- أداة 1 -->
            <div class="tool-card">
                <img src="images/support0.jpg" alt="لوحة فحص النظر">
                <h3>لوحة فحص النظر</h3>
                <p>تُستخدم لاختبار حدة البصر عن طريق قراءة الحروف من مسافة معينة.</p>
            </div>

            <!-- أداة 2 -->
            <div class="tool-card">
                <img src="images/support1.jpg" alt="جهاز فحص العيون">
                <h3>جهاز فحص العيون</h3>
                <p>يُستخدم لفحص الشبكية وقياس النظر وتشخيص مشاكل العين بدقة.</p>
            </div>

            <!-- أداة 3 -->
            <div class="tool-card">
                <img src="images/support2.jpg" alt="سرير طبي">
                <h3>سرير طبي</h3>
                <p>يُستخدم لفحص المرضى خلال جلسات العلاج أو الفحوص الطبية.</p>
            </div>

            <!-- أداة 4 -->
            <div class="tool-card">
                <img src="images/support3.jpg" alt="غرفة صفية">
                <h3>غرف تعليمية</h3>
                <p>تُستخدم لبرامج التأهيل والتعليم وورش العمل لذوي الإعاقة.</p>
            </div>

            <!-- أداة 5 -->
            <div class="tool-card">
                <img src="images/support4.jpg" alt="دراجة تمرين">
                <h3>دراجة تمرين</h3>
                <p>تُستخدم في العلاج الطبيعي لتحسين حركة الأرجل وتنشيط الدورة الدموية.</p>
            </div>



            <!-- أداة 6 -->
            <div class="tool-card">
                <img src="images/support5.jpg" alt="علاج طبيعي">
                <h3>علاج طبيعي وتأهيل حركي</h3>
                <p>يُستخدم لتحسين القدرة الحركية وتنشيط العضلات وتعزيز الاستقلالية الحركية لذوي الإعاقة.</p>
            </div>

            <!-- أداة 10 -->
            <div class="tool-card">
                <img src="images/support.jpg" alt="أدوية">
                <h3>أدوية ومستلزمات طبية</h3>
                <p>توفير الأدوية الأساسية والمستلزمات الطبية ضمن برامج الدعم الصحي للمحتاجين.</p>
            </div>



            <!-- أداة 8 -->
            <div class="tool-card">
                <img src="images/support7.jpg" alt="فحص طبي">
                <h3>فحص طبي للأطفال</h3>
                <p>تقديم رعاية طبية وتشخيص مبكر من خلال فحص الأطفال باستخدام أجهزة القلب والسمع وغيرها.</p>
            </div>

            <!-- أداة 7 -->
            <div class="tool-card">
                <img src="images/support6.jpg" alt="المواد التموينية">
                <h3>خدمات غذائية </h3>
                <p>توزيع الطرود الغذائية للأسر المحتاجة ضمن برامج الجمعية الخيرية.</p>
            </div>

            <!-- أداة 9 -->
            <div class="tool-card">
                <img src="images/support8.jpg" alt="خدمات تموينية">
                <h3> مواد تموينية </h3>
                <p>توزيع المواد التموينية بأنواعها المختلفة للأسر المحتاجة ضمن برامج الجمعية الخيرية.</p>

            </div>



    </section>

    <!-- قسم لماذا خدماتنا -->
    <section class="why-us">
        <h2>لماذا خدماتنا؟</h2>
        <ul>
            <li>فريق متخصص ذو خبرة في مجال التأهيل والدعم.</li>
            <li>خدمات مخصصة حسب احتياجات كل حالة.</li>
            <li>التزام بالمعايير الأخلاقية والإنسانية.</li>
            <li>نؤمن بقدرات ذوي الإعاقة ونسعى لتمكينهم في المجتمع.</li>
            <li>نتعامل مع كل مستفيد باحترام وخصوصية.</li>
            <li>نعمل بشفافية ومصداقية في تقديم خدماتنا.</li>
            <li>دعم نفسي واجتماعي متكامل.</li>
        </ul>
    </section>

    <!-- قسم تواصل معنا -->
    <section class="contact-cta">
        <h3>هل تحتاج إلى مساعدتنا؟</h3>
        <a href="{{url('/contact')}}" class="btn contact-btn"> تواصل معنا الآن</a>
    </section>
    <br>

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

@endsection

@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/contact.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
@endpush

@section('title', 'تواصل معنا')

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
    {{--end nav--}}

    <section class="contact-wrapper ">
        <h1 class="section-title h1">تواصل معنا</h1>
        <div class="form-box">
            <form>

                @csrf
                <label for="name">الاسم:</label>
                <input type="text" name="name" placeholder="أدخل اسمك الرباعي" id="name" required>

                <label for="phone">رقم الجوال:</label>
                <input type="tel" name="phone" placeholder="أدخل رقم هاتفك" id="phone" required>

                <label for="email">البريد الإلكتروني:</label>
                <input type="email" name="email" placeholder="أدخل بريدك الإلكتروني" id="email" required>

                <label for="request_type">نوع الطلب:</label>
                <select name="request_type" id="request_type" required>
                    <option value="" disabled selected hidden>اختر نوع الطلب</option>
                    <option value="استفسار">استفسار</option>
                    <option value="اقتراح">تقديم اقتراح</option>
                    <option value="شكوى">تقديم شكوى </option>
                </select>

                <label for="message">الرسالة:</label>
                <textarea name="message" id="message" rows="5" required></textarea>

                <button type="submit" class="submit-btn">إرسال</button>
            </form>
        </div>

        <h2 class="section ">قياس مستوى الرضا</h2>
        <div class="form-box satisfaction-box">
            <form action="#" method="POST">
                @csrf
                <label for="user_type">الصِّفة:</label>
                <select name="user_type" id="user_type" required>
                    <option value="" disabled selected hidden >اختر الصفة</option>
                    <option value="مستفيد">مستفيد</option>
                    <option value="موظف">موظف</option>
                </select>

                <label for="satisfaction_level">ما مدى رضاك عن الخدمات التي تقدمها الجمعية؟</label>
                <select name="satisfaction_level" id="satisfaction_level" required>
                    <option value="">اختر مستوى الرضا</option>
                    <option value="راض">راض</option>
                    <option value="راض جدا">راض جدا</option>
                    <option value="غير راض">غير راض</option>
                </select>

                <label for="suggestion">اقتراحاتك:</label>
                <textarea name="suggestion" id="suggestion" rows="3" placeholder="أدخل اقتراحاتك هنا..."></textarea>

                <button type="submit" class="submit-btn" disabled id="submitBtn2">إرسال</button>
            </form>
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

    @push('js')
        <script src="{{ asset('js/welcome.js') }}"></script>

        <script>
            const form = document.querySelector("form");
            const submitBtn = document.getElementById("submitBtn");

            form.addEventListener("input", () => {
                const isValid = form.checkValidity();
                submitBtn.disabled = !isValid;

                // لو النموذج كامل فعّل لون الزر
                if (isValid) {
                    submitBtn.classList.add("active");
                } else {
                    submitBtn.classList.remove("active");
                }
            });
        </script>
    @endpush


@endsection


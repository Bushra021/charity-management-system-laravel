document.addEventListener('DOMContentLoaded', function () {
    // القائمة الجانبية
    const menuBtn = document.querySelector('.menu-button');
    const sidebar = document.querySelector('.sidebar');
    const closeBtn = document.querySelector('.sidebar .close-btn');
    const nav = document.querySelector('.nav');
    const logo = document.querySelector('.logo');
    const logoText = document.querySelector('.logo-text');
    const btns = document.querySelectorAll('.btn');

    if (menuBtn && sidebar && closeBtn) {
        menuBtn.addEventListener('click', () => {
            sidebar.classList.add('active');
            document.body.style.overflow = 'hidden';
            menuBtn.style.display = 'none';
        });

        closeBtn.addEventListener('click', () => {
            sidebar.classList.remove('active');
            document.body.style.overflow = 'auto';
            menuBtn.style.display = 'block';
        });
    }

    document.addEventListener('click', function (event) {
        if (sidebar && menuBtn && sidebar.classList.contains('active') &&
            !sidebar.contains(event.target) &&
            !menuBtn.contains(event.target)) {
            sidebar.classList.remove('active');
            document.body.style.overflow = 'auto';
            menuBtn.style.display = 'block';
        }
    });

    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            logo.classList.add('small-logo');
            logoText.classList.add('small-logo-text');
            nav.classList.add('small-nav');
            btns.forEach(btn => btn.classList.add('small-btn'));
        } else {
            logo.classList.remove('small-logo');
            logoText.classList.remove('small-logo-text');
            nav.classList.remove('small-nav');
            btns.forEach(btn => btn.classList.remove('small-btn'));
        }
    });

    // الأكوردين
    document.querySelectorAll('.accordion-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const content = btn.nextElementSibling;
            const isOpen = content.classList.contains('open');

            document.querySelectorAll('.accordion-content').forEach(c => {
                c.classList.remove('open');
                c.previousElementSibling.classList.remove('active');
            });

            if (!isOpen) {
                content.classList.add('open');
                btn.classList.add('active');
            }
        });
    });

    // الكاروسيل
    const carousel = document.querySelector('#quoteSlider');
    const indicators = document.querySelectorAll('.custom-carousel-indicators button');

    if (carousel) {
        carousel.addEventListener('slide.bs.carousel', function (e) {
            indicators.forEach(btn => btn.classList.remove('active'));
            indicators[e.to].classList.add('active');
        });
    }
});

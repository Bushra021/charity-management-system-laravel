@php use App\Models\Effect; @endphp
@extends('layouts.master')
@section('page')

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <div class="dashboard-container">

        <div class="sidebar">
            <h3>لوحة التحكم</h3>

            <a href="{{route('profile.info')}}">المعلومات الشخصية </a><br>

            <a href="{{route('appointments.available')}}">الحجوزات والمواعيد </a><br>

            <a href="{{route('assistive tool.create')}}">الادوات  </a><br>

            <a href="{{route('provided services.create')}}">الخدمات </a> <br>

            <a href="{{route('patient.reports.create')}}">التقارير </a> <br>
            <a href="{{route('profile.show')}}">معلومات الحساب</a>
        </div>

        <div class="main-content">
            <div class="header">
                <div class="user-name">مرحباً،
                    {{auth()->user()->name}}
                </div>

                <img src="{{ asset('storage/' . (Auth::user()->profile_picture ?? 'defaults/profile.jpg')) }}" width="150" alt="الصورة الشخصية">
                <div class="logout-btn">
                    <a href="{{route('logout')}}">تسجيل خروج </a><br>
                </div>
            </div>

            <div class="welcome-message">
                <i class="fa-solid fa-notes-medical" style="color: #2c3e50; font-size: 45px"></i>
                <h2>أهلاً وسهلاً بك عزيزي المراجع</h2>
                <p>نحن هنا لمساعدتك. يمكنك حجز موعد، أو استعراض معلوماتك الصحية من خلال الخيارات المتاحة.</p>
            </div>

        </div>
    </div>

    @php
        $effect = Effect::where('patient_id', auth()->user()->patient->id ?? null)->first();
    @endphp

    @if (!$effect)
        <div id="effect-reminder" data-show-effect="true"></div>
    @endif

@endsection


@push('js')
    @if (!$effect)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const reminder = document.getElementById('effect-reminder');
                const shouldShowEffect = reminder?.dataset.showEffect === 'true';

                if (shouldShowEffect) {

                    Swal.fire({
                        title: 'تنبيه مهم',
                        text: 'لم يتم استكمال معلوماتك الشخصية بعد. يُرجى تعبئة نموذج تأثير الإعاقة للمتابعة.',
                        icon: 'warning',
                        confirmButtonText: 'الذهاب للنموذج',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,

                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('effect.create') }}";
                        }
                    });
                }
            });
        </script>
    @endif
@endpush

@extends('layouts.master')

@section('page')
    <div class="container">
        <h2>تفاصيل الحالة</h2>

        @if($donation->photo)
            <img src="{{ asset('storage/' . $donation->photo) }}" style="width: 100%; max-height: 400px; object-fit: cover; margin-bottom: 20px;">
        @endif

        <div>
            <p>{{ $donation->post }}</p>
        </div>

        <a href="#" style="display: inline-block; margin-top: 20px; background: #28a745; color: white; padding: 10px 20px; border-radius: 5px;">تبرع الآن</a>
    </div>
@endsection


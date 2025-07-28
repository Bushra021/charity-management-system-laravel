@extends('layouts.master')

@section('page')
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">

    <div class="container">

        <h2>هل نسيت كلمة المرور؟</h2>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <input type="text" name="username" placeholder="البريد الإلكتروني" required>
            @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <button type="submit">إرسال رابط إعادة التعيين</button>
        </form>
    </div>


@endsection

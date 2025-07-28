@extends('layouts.master')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f9f9f9;
            direction: rtl;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
            text-align: center;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        h2 {
            color: #2b6777;
            margin-bottom: 25px;
            font-weight: 600;
        }
        form {
            text-align: right;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #444;
        }
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.3s;
        }
        input[type="password"]:focus {
            border-color: #2b6777;
            outline: none;
            box-shadow: 0 0 5px rgba(43, 103, 119, 0.3);
        }
        span {
            display: block;
            margin-bottom: 10px;
            color: red;
            font-size: 14px;
        }
        button[type="submit"] {
            background-color: #2b6777;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
        }
        button[type="submit"]:hover {
            background-color: #1e4d5a;
        }
    </style>
@endpush

@section('page')
    <div class="container">
        <h2>إعادة تعيين كلمة المرور</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="username" value="{{ $username }}">

            <div>
                <label for="password">كلمة المرور الجديدة</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                <span>{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password_confirmation">تأكيد كلمة المرور</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                @error('password_confirmation')
                <span>{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">إعادة تعيين كلمة المرور</button>
        </form>
    </div>
@endsection

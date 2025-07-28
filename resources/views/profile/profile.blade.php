@extends('layouts.master')

@section('page')
    <style>
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fafafa;
            font-family: Arial, sans-serif;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            margin-top: 15px;
        }
        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #2c7be5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #1a5fc1;
        }
        .error-message {
            color: #d32f2f;
            font-size: 14px;
            margin-top: 4px;
        }
        .success-message {
            color: #388e3c;
            font-size: 15px;
            margin-top: 20px;
            text-align: center;
        }
        .current-image {
            margin-top: 10px;
            max-width: 120px;
            max-height: 120px;
            border-radius: 8px;
            border: 1px solid #ccc;
            display: block;
        }
    </style>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>الصورة الشخصية الحالية:</label>
        @if(Auth::user()->profile_picture)
            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="الصورة الشخصية" class="current-image">
        @else
            <p>لا توجد صورة شخصية حالياً.</p>
        @endif

        <label for="profile_picture">تغيير الصورة الشخصية:</label>
        <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
        @error('profile_picture')
        <div class="error-message">{{ $message }}</div>
        @enderror

        <label for="name">الاسم:</label>
        <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}">
        @error('name')
        <div class="error-message">{{ $message }}</div>
        @enderror

        <label for="username">البريد الإلكتروني:</label>
        <input type="email" name="username" id="username" value="{{ old('username', Auth::user()->username) }}">
        @error('username')
        <div class="error-message">{{ $message }}</div>
        @enderror

        <button type="submit">تحديث</button>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
    </form>
@endsection

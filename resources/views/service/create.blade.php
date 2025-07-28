@extends('layouts.master')
@section('page')

    <div class="container">
        <h2>إضافة خدمة جديدة</h2>

        <form action="{{ route('services.store') }}" method="POST">
            @csrf
            <input type="text" name="name" id="name" required>

            <div class="mb-3">
                <select name="user_id" id="user_id" required>
                    <option value="">اختر الموظف المسؤول</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>

            </div>

            <button type="submit" class="btn btn-primary">إضافة</button>
        </form>
    </div>

@endsection

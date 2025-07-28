@extends('layouts.master')
@section('page')
    <form action="{{ route('services.update', $service->id)}}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $service->name }}" id="name" required>
        <select name="user_id" id="user_id" required>
            <option value="">اختر الموظف</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected($service->user_id == $user->id)>{{ $user->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
@endsection

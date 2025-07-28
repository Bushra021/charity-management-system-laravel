@extends('layouts.master')
@section('page')
<form action="{{ route('grades.update', $grade->id)}}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $grade->name }}" id="name" required>
    <button type="submit" class="btn btn-primary">تحديث</button>
</form>
@endsection

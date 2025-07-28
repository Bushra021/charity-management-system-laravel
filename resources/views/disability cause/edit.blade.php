@extends('layouts.master')
@section('page')
<form action="{{ route('disability causes.update', $disabilitycause->id)}}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $disabilitycause->name }}" id="name" required>
    <button type="submit" class="btn btn-primary">تحديث</button>
</form>
@endsection

@extends('layouts.master')
@section('page')

<form action="{{ route('tools.update', $tool->id)}}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $tool->name }}" id="name" required>
    <input type="number" name="price" value="{{ $tool->price }}" id="price" required>

    <button type="submit" class="btn btn-primary">تحديث</button>
</form>
@endsection


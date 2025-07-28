@extends('layouts.master')
@section('page')
<div class="container">
    <h2>إضافة أداة جديدة</h2>

    <form action="{{ route('tools.store') }}" method="POST">
        @csrf
        <label for="name">اسم الأداة:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="price">السعر:</label>
        <input type="number" name="price" id="price" step="0.01" required>

        <button type="submit" class="btn btn-primary">إضافة</button>
    </form>
</div>
@endsection

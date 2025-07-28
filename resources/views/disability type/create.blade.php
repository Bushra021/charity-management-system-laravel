@extends('layouts.master')
        @section('page')

            <div class="container">
                <h2>إضافة درجة جديدة</h2>

                <form action="{{ route('disability causes.store') }}" method="POST">
                    @csrf
        <input type="text" name="name" id="name" required>
        <button type="submit" class="btn btn-primary">إضافة</button>
    </form>
</div>
@endsection

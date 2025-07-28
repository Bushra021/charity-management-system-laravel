@extends('layouts.master')
@section('page')

    {{ auth()->user()->name }}

    Dashboard
    <a href="{{route('logout')}}">تسجيل خروج</a>
@endsection

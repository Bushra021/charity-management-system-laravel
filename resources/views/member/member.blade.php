@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">
@push('css')
    <link href="/css/areas.css" rel="stylesheet">
@endpush

@section('page')
    <hr/>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif



        <h2>👨‍👩‍👧‍👦 أفراد العائلة</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
            <tr>
                <th>الاسم</th>
                <th>سنة الميلاد</th>
                <th>العلاقة</th>
                <th>الحالة الاجتماعية</th>
                <th>المستوى الأكاديمي</th>
                <th>الحالة الصحية</th>
                <th>هل لديه إعاقة؟</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($members as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->birth_year }}</td>
                    <td>{{ $member->relationship }}</td>
                    <td>{{ $member->social_status }}</td>
                    <td>{{ $member->academic_level }}</td>
                    <td>{{ $member->health_status }}</td>
                    <td>{{ $member->has_disability ? 'نعم' : 'لا' }}</td>
                    <td>
                        <form action="{{ route('member.destroy', $member->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الفرد؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: red;">🗑 حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">لا يوجد أفراد في هذه العائلة.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <a href="{{ route('member.create') }}" style="color: #0b8043; text-decoration: none; font-weight: bold;">
            اضافة فرد عائلة جديد
        </a>
@endsection

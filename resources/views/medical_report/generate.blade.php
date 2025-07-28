@extends('layouts.master')
@section('page')
    <div class="container">
        <h2>رفع تقرير طبي</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- الرابط يظهر فقط إن وُجِد --}}
        @if(session('report_url'))
            <a href="{{ session('report_url') }}" target="_blank" class="btn btn-info mb-3">
                فتح التقرير المُنشأ فى تبويب جديد
            </a>
        @endif
        <a href="{{ route('patient.reports.generate') }}" class="btn btn-warning mb-3">توليد تقرير طبي تلقائي</a>


        <hr>

        <h3>تقاريري المرفوعة</h3>

        @if($reports->isEmpty())
            <p>لا يوجد تقارير.</p>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>العنوان</th>
                    <th>تاريخ الرفع</th>
                    <th>خيارات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->title }}</td>
                        <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $report->file_path) }}" class="btn btn-sm btn-primary" target="_blank">عرض</a>
                            <a href="{{ asset('storage/' . $report->file_path) }}" class="btn btn-sm btn-success" download>تحميل</a>


                            <form action="{{ route('patient.reports.destroy', $report->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا التقرير؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

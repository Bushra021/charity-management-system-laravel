<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'tajawal', sans-serif;
            direction: rtl;
            text-align: right;
            padding: 40px;
            border: 3px solid #333;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            max-width: 120px;
            margin-bottom: 10px;
        }

        .org-name {
            font-size: 20px;
            font-weight: bold;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 1px solid #999;
            padding-bottom: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .info-table th {
            text-align: right;
            background-color: #f2f2f2;
            width: 20%;
        }

        .info-table td {
            text-align: right;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }

        .signature {
            margin-top: 40px;
            font-size: 15px;
            font-weight: bold;
        }

        .report-date {
            margin-top: 10px;
            font-size: 13px;
            text-align: left;
            direction: ltr;
        }

        .footer {
            margin-top: 50px;
            font-size: 13px;
            line-height: 1.8;
            border-top: 1px dashed #888;
            padding-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('images/logo.jpg') }}" alt="شعار الجمعية">
    <div class="org-name">جمعية الرحمة الخيرية للتأهيل</div>
</div>

<div class="section-title">المعلومات الشخصية</div>
<table class="info-table">
    <tr>
        <th>الاسم</th>
        <td>{{ $patient->name }}</td>
        <th>رقم الهوية</th>
        <td>{{ $patient->national_id }}</td>
    </tr>
    <tr>
        <th>تاريخ الميلاد</th>
        <td>{{ $patient->birth_date }}</td>
        <th>تاريخ الإصابة</th>
        <td>{{ $patient->injury_date }}</td>
    </tr>
    <tr>
        <th>الحالة الاجتماعية</th>
        <td>{{ $patient->social_status }}</td>
        @if($disability_type)
            <th>نوع الإعاقة</th>
            <td>{{ $disability_type->name }}</td>
        @else
            <th>نوع الإعاقة</th>
            <td>---</td>
        @endif
    </tr>
    <tr>
        @if($disability_cause)
            <th>سبب الإعاقة</th>
            <td colspan="3">{{ $disability_cause->name }}</td>
        @else
            <th>سبب الإعاقة</th>
            <td colspan="3">---</td>
        @endif
    </tr>
</table>

<div class="section-title">الخدمات المقدمة</div>
@if($patient->providedServices->isNotEmpty())
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>الخدمة</th>
            <th>تاريخ البداية</th>
            <th>تاريخ النهاية</th>
            <th>الحالة</th>
        </tr>
        </thead>
        <tbody>
        @foreach($patient->providedServices as $service)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $service->service->name }}</td>
                <td>{{ $service->start_date ?? '-' }}</td>
                <td>{{ $service->end_date ?? '-' }}</td>
                <td>
                    @php
                        $statusMap = [
                            'pending'   => 'لقد تم طلبها',
                            'scheduled' => 'يتلقاها الآن',
                            'completed' => 'مكتملة',
                        ];
                    @endphp
                    {{ $statusMap[$service->status] ?? 'غير معروف' }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>لا توجد خدمات مقدمة.</p>
@endif

<div class="section-title">المواعيد</div>
@if($patient->appointments->isNotEmpty())
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>تاريخ الموعد</th>
            <th>الخدمة</th>
            <th>الحالة</th>
        </tr>
        </thead>
        <tbody>
        @foreach($patient->appointments as $appointment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $appointment->date }}</td>
                <td>{{ $appointment->service->name ?? '---' }}</td>
                <td>{{ $appointment->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>لا توجد مواعيد مسجلة لهذا المريض.</p>
@endif

<div class="section-title">الملاحظات</div>
@if($patient->notes->isNotEmpty())
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>الملاحظة</th>
            <th>التاريخ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($patient->notes as $note)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $note->name }}</td>
                <td>{{ $note->date }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>لا توجد ملاحظات.</p>
@endif

<div class="signature">توقيع الباحث الاجتماعي: ......................................</div>

<div class="report-date">
    تاريخ إعداد التقرير: {{ \Carbon\Carbon::now()->format('Y-m-d') }}
</div>

<div class="footer">
    البريد الإلكتروني: alrahma.society2006@gmail.com
    جوال: 0599830516
    تلفاكس: 02-2582110
    العنوان: بيت أولا - الخليل / خلف بلدية بيت أولا
    رقم الحساب البنكي: 10048249
    البنك الوطني - فرع الخليل
</div>

</body>
</html>

@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">
@push('css')
    <link href="{{ asset('css/note-info.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

@endpush

@section('page')


    <div class="dashboard-container">
        <div class="sidebar">
            <h3>لوحة التحكم</h3>


            <a href="{{route('appointment.index')}}">المواعيد</a><br>
            <a href="{{route('search-patient')}}"> الملاحظات </a><br>
            <a href="{{route('employee.service')}}">الخدمات المطلوبة </a><br>
            <a href="{{route('employee.service done')}}">الخدمات الجارية والمنهية </a><br>
            <a href="{{route('profile.show')}}">معلومات الحساب</a>



        </div>

        <div class="main-content">
            <div class="header">
                <div class="user-name">مرحباً، {{ auth()->user()->name }}</div>

                <img src="{{ asset('storage/' . (Auth::user()->profile_picture ?? 'defaults/profile.jpg')) }}" width="150" alt="الصورة الشخصية">

                <div class="logout-btn">
                    <a href="{{ route('logout') }}">تسجيل الخروج</a>
                </div>
            </div>
            <div class="container">
                <h1 class="mb-4">معلومات المريض: {{ $patient->name }}</h1>

                {{-- معلومات أساسية --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">معلومات أساسية</h5>
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th> رقم الهوية</th>
                                <td>{{ $patient->national_id }}</td>
                            </tr>
                            <tr>
                                <th>تاريخ الميلاد</th>
                                <td>{{ $patient->birth_date }}</td>
                            </tr>
                            <tr>
                                <th>الحالة الاجتماعية</th>
                                <td>{{ $patient->social_status }}</td>
                            </tr>
                            <tr>
                                <th>سبب الاعاقة</th>
                                <td>{{ $patient->disabilitycause->name }}</td>
                            </tr>
                            <tr>
                                <th>نوع  الاعاقة</th>
                                <td>{{ $patient->disabilitytype->name }}</td>
                            </tr>

                            <tr>
                                <th>نسبة الاعتماد على النفس</th>
                                <td>{{ $patient->self_dependence_level }}%</td>
                            </tr>
                            <tr>
                                <th>تاريخ الإصابة</th>
                                <td>{{ $patient->injury_date }}</td>
                            </tr>
                            <tr>
                                <th>رقم الهاتف</th>
                                <td>{{ $patient->phone_number }}</td>
                            </tr>
                            <tr>
                                <th>رقم الفاكس</th>
                                <td>{{ $patient->fax_number }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- المرفقات --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">المرفقات (الأدوات المطلوبة)</h5>
                        @if($patient->attachments->isNotEmpty())
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> الأداة</th>
                                    <th>تم الاستلام</th>
                                    <th>يحتاج</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patient->attachments as $attachment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attachment->tool->name ?? 'غير معروف' }}</td>
                                        <td>{{ $attachment->received ? 'نعم' : 'لا' }}</td>
                                        <td>{{ $attachment->needed ? 'نعم' : 'لا' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>لا توجد مرفقات.</p>
                        @endif
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">تأثير الإعاقة</h5>
                        @if($patient->effect)
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>الصحة الجسدية</th>
                                    <th>الصحة العقلية</th>
                                    <th>الصحة النفسية</th>
                                    <th>التعليم</th>
                                    <th>الحياة الزوجية</th>
                                    <th>الأنشطة الاجتماعية</th>
                                    <th>المهارات الاجتماعية</th>
                                    <th>الإدارة الذاتية</th>
                                    <th>العلاقات الأسرية</th>
                                    <th>العمل</th>
                                    <th>الاستقلال المالي</th>
                                    <th>الحياة العامة</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $patient->effect->healthPhysicalGrade->name ?? 'غير محدد' }}</td>
                                    <td>{{ $patient->effect->healthMentalGrade->name ?? 'غير محدد' }}</td>
                                    <td>{{ $patient->effect->healthPsychologicalGrade->name ?? 'غير محدد' }}</td>
                                    <td>{{ $patient->effect->educationGrade->name ?? 'غير محدد' }}</td>
                                    <td>{{ $patient->effect->maritalLifeGrade->name ?? 'غير محدد' }}</td>
                                    <td>{{ $patient->effect->socialActivitiesGrade->name ?? 'غير محدد' }}</td>
                                    <td>{{ $patient->effect->socialSkillsGrade->name ?? 'غير محدد' }}</td>
                                    <td>{{ $patient->effect->selfManagementGrade->name ?? 'غير محدد' }}</td>
                                    <td>{{ $patient->effect->familyRelationshipGrade->name ?? 'غير محدد' }}</td>
                                    <td>{{ $patient->effect->workGrade->name ?? 'غير محدد' }}</td>
                                    <td>{{ $patient->effect->financialIndependenceGrade->name ?? 'غير محدد' }}</td>
                                    <td>{{ $patient->effect->publicLifeGrade->name ?? 'غير محدد' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        @else
                            <p class="text-danger">لا يوجد تأثير مسجل للمريض.</p>
                        @endif
                    </div>
                </div>


                {{-- الخدمات المقدمة --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">الخدمات المقدمة</h5>
                        @if($patient->providedServices->isNotEmpty())
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> الخدمة</th>
                                    <th>تم الاستلام</th>
                                    <th>يحتاج اليها</th>
                                    <th>تاريخ البدء</th>
                                    <th>تاريخ الانتهاء</th>
                                    <th>الحالة</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patient->providedServices as $providedServices)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$providedServices->service->name}}</td>
                                        <td>{{ $providedServices->received ? 'نعم' : 'لا' }}</td>
                                        <td>{{ $providedServices->needed ? 'نعم' : 'لا' }}</td>
                                        <td>{{$providedServices->start_date ?? '-'}}</td>
                                        <td>{{$providedServices->end_date ?? '-'}}</td>
                                        <td>
                                            @php
                                                $statusMap = [
                                                    'pending'   => ' لقد تم طلبها ',
                                                    'scheduled' => 'يتلفاها الان  ',
                                                    'completed' => 'مكتملة',
                                                ];
                                            @endphp
                                            {{ $statusMap[$providedServices->status] ?? 'غير معروف' }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>لا توجد خدمات مقدمة.</p>
                        @endif
                    </div>
                </div>

                {{-- المواعيد --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">المواعيد</h5>

                        @if($patient->appointments->isNotEmpty())
                            <table class="table table-striped">
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
                                        <td>{{$appointment->status}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">لا توجد مواعيد مسجلة لهذا المريض.</p>
                        @endif

                    </div>
                </div>

                {{-- الملاحظات --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">الملاحظات</h5>

                        {{-- عرض التنبيه في حال النجاح --}}
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- قائمة الملاحظات --}}
                        @if($patient->notes->isNotEmpty())
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الملاحظة</th>
                                    <th>التاريخ</th>
                                    <th>الإجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patient->notes as $note)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $note->name }}</td>
                                        <td>{{ $note->date }}</td>

                                        <td>

                                            @if ($note->user_id === auth()->id())
                                                {{-- زر تعديل --}}
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editNoteModal{{ $note->id }}">
                                                    تعديل
                                                </button>

                                                {{-- زر حذف --}}
                                                <form action="{{ route('notes.destroy', ['patient' => $patient->id, 'note' => $note->id]) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                                                </form>
                                        </td>
                                    </tr>

                                    {{-- مودال تعديل الملاحظة --}}
                                    <div class="modal fade" id="editNoteModal{{ $note->id }}" tabindex="-1" aria-labelledby="editNoteLabel{{ $note->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('notes.update', [$patient->id, $note->id]) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editNoteLabel{{ $note->id }}">تعديل الملاحظة</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{-- نص الملاحظة --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">نص الملاحظة</label>
                                                            <textarea name="name"
                                                                      class="form-control @error('name') is-invalid @enderror"
                                                                      maxlength="1000"
                                                                      required>{{ old('name', $note->name) }}</textarea>
                                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                        </div>

                                                        {{-- تاريخ الملاحظة --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">تاريخ الملاحظة</label>
                                                            <input type="date"
                                                                   name="date"
                                                                   class="form-control @error('date') is-invalid @enderror"
                                                                   max="{{ now()->toDateString() }}"
                                                                   value="{{ old('date', $note->date) }}"
                                                                   required>
                                                            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">لا توجد ملاحظات مسجلة.</p>
                        @endif
                    </div>
                </div>

                {{-- إضافة ملاحظة جديدة --}}
                <form action="{{ route('notes.store', $patient->id) }}" method="POST" class="mb-4">
                    @csrf

                    {{-- نص الملاحظة --}}
                    <div class="card mb-4">
                        <div class="card-body">
                            <label for="name" class="form-label">نص الملاحظة</label>
                            <textarea name="name"
                                      id="name"
                                      class="form-control @error('name') is-invalid @enderror"
                                      maxlength="1000"
                                      required>{{ old('name') }}</textarea>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- تاريخ الملاحظة --}}
                    <div class="card mb-4">
                        <div class="card-body">
                            <label for="date" class="form-label">تاريخ الملاحظة</label>
                            <input type="date"
                                   name="date"
                                   id="date"
                                   class="form-control flatpickr-birth pe-5 w-100" @error('date')<span class="is-invalid">  </span>  @enderror"
                            max="{{ now()->toDateString() }}"
                            value="{{ old('date') }}"
                            required>
                            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">إضافة ملاحظة</button>
                    </div>
                </form>
                {{-- التقارير الطبية --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">التقارير الطبية</h5>
                        <a href="{{ route('patient.reports.generate', $patient->id) }}" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> توليد التقرير
                        </a>


                        @if($patient->medicalReports->isNotEmpty())
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>العنوان</th>
                                    <th>منشأ تلقائي؟</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>رابط التقرير</th>
                                    <th>إجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patient->medicalReports as $report)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $report->title }}</td>
                                        <td>{{ $report->is_generated ? 'نعم' : 'لا' }}</td>
                                        <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $report->file_path) }}"
                                               target="_blank" class="btn btn-sm btn-outline-primary">
                                                عرض التقرير
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('patient.reports.destroy', $report->id) }}" method="POST"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف التقرير؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">🗑 حذف</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">لا توجد تقارير طبية مسجلة.</p>
                        @endif
                    </div>
                </div>



        </div>
    </div>




    @push('js')

            <script>
                // ========== 1. التقويم لتاريخ الميلاد ==========
                const birthInput = document.querySelector(".flatpickr-birth");
                const birthCalendar = flatpickr(birthInput, {
                    dateFormat: "Y-m-d",
                    maxDate: "today",
                    locale: "ar"
                });

                document.getElementById("calendar-birth-icon").addEventListener("click", () => {
                    birthCalendar.open();
                });
            </script>


    @endpush

@endsection




<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AvailableAppointmentController;
use App\Http\Controllers\DisabilityCauseController;
use App\Http\Controllers\DisabilityTypeController;
use App\Http\Controllers\EffectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeServicesController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\langcontroller;
use App\Http\Controllers\MedicalReportController;
use App\Http\Controllers\MotherController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PatientAssistiveToolController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProvidedServiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
use App\Models\DisabilityCause;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {

         switch(Auth::user()->role) {// الحصول على المستخدم المصادق عه
            case 'admin':
                return redirect()->route('admin');
            case 'employee':
                return redirect()->route('employee');
            case 'employee_services':
                return redirect()->route('employee_s');
            case 'patient':
                return redirect()->route('patient');
        }
    }
    return view('welcome');
});


Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/'); // إعادة توجيه المستخدم إلى الصفحة الرئيسية
})->name('logout');



Route::get('/users/reg_form',[UserController::class,'reg_form'])->name("reg_form");
Route::post('/users/register',[UserController::class,'register'])->name("register");
Route::get('/users/dashboard',[UserController::class,'dashboard'])->name('dashboard');
Route::get('users/logout',[UserController::class,'logout'])->name('logout');
Route::get('/users/log_form',[UserController::class,'log_form'])->name("log_form");

Route::post('/users/login', [UserController::class, 'login'])->middleware('throttle:3,1')->name('login');


Route::middleware(['ensure.patient.profile.completed','patient'])->group(function () {
    Route::get('/patient/cp', [PatientController::class, 'patient'])->name('patient');
});

Route::middleware(['patient'])->group(function () {

Route::get('/patients/create', [patientController::class, 'create'])->name('patients.create');
Route::post('/patients', [patientController::class, 'store'])->name('patients.store');
    Route::get('/patient/profile/info', [PatientController::class, 'createprofile'])->name('profile.info');
    Route::post('/patient/{id}/update-field', [PatientController::class, 'updateField'])->name('patient.updateField');

    Route::get('/patient/families/info', [FamilyController::class, 'createprofile'])->name('profile.family.info');
    Route::post('/patient/{id}/update-field-family', [FamilyController::class, 'updateField'])->name('family.updateField');

    Route::get('/patient/mothers/info', [MotherController::class, 'createprofile'])->name('profile.mother.info');
    Route::post('/patient/{id}/update-field-mother', [MotherController::class, 'updateField'])->name('mother.updateField');

    Route::get('/patient/effects/info', [EffectController::class, 'createprofile'])->name('profile.effect.info');
    Route::post('/patient/{id}/update-field-effect', [EffectController::class, 'updateField'])->name('effect.updateField');

    Route:: delete('/patient/members/delelte/ {id} ', [FamilyMemberController:: class, 'destroy'])->name('member.destroy');
    Route::get('patient/members/show', [FamilyMemberController::class, 'show'])->name('member.show');

    Route::get('/families/create', [FamilyController::class, 'create'])->name('families.create');
    Route::get('/check-father/{id}', [FamilyController::class, 'checkFather'])->name('check-father');
    Route::post('/families', [FamilyController::class, 'store'])->name('families.store');

    Route::get('/patients/provided service', [ProvidedServiceController::class, 'create'])->name('provided services.create');
    Route::post('/patients/provided service', [ProvidedServiceController::class, 'store'])->name('provided services.store');
    Route:: delete('/patients/provided service/delete/{id} ', [ProvidedServiceController:: class, 'destroy'])->name('provided service.destroy');

    Route::get('/patients/assistive tool', [PatientAssistiveToolController::class, 'create'])->name('assistive tool.create');
    Route::post('/patients/assistive tool', [PatientAssistiveToolController::class, 'store'])->name('assistive tool.store');
    Route:: delete('/patients/assistive tool/delete/ {id} ', [PatientAssistiveToolController:: class, 'destroy'])->name('assistive tool.destroy');

    Route::get('/patients/effect', [EffectController::class, 'create'])->name('effect.create');
    Route::post('/patients/effect', [EffectController::class, 'store'])->name('effect.store');

    Route::get('/patients/member', [FamilyMemberController::class, 'create'])->name('member.create');
    Route::post('/patients/member', [FamilyMemberController::class, 'store'])->name('member.store');

    Route::get('/appointments/available', [AppointmentController::class, 'showAvailableAppointments'])->name('appointments.available');
    Route::post('/appointments/book/{id}', [AppointmentController::class, 'bookAppointment'])->name('appointments.book');
    Route::delete('/appointments/cancel/{id}', [AppointmentController::class, 'destroy'])->name('appointments.cancel');



    Route::get('/mothers/create', [MotherController::class, 'create'])->name('mothers.create');
    Route::post('/mothers', [MotherController::class, 'store'])->name('mothers.store');
    Route::get('/check-mother/{id}', [MotherController::class, 'checkMother']);

    Route::get('/my-reports/create2', [MedicalReportController::class, 'create'])->name('patient.reports.create');
Route::post('/my-reports/add', [MedicalReportController::class, 'store'])->name('patient.reports.store');
Route::get('/my-reports/show', [MedicalReportController::class, 'index'])->name('patient.reports.index');
Route::delete('/my-reports/{report}', [MedicalReportController::class, 'destroy'])->name('patient.reports.destroy');


});


    Route::middleware(['admin'])->group(function () {

   Route::get('/admin/cp',[AdminController::class,'admin'])->name('admin');
    Route::put('/admin/role/{id}/update', [AdminController::class, 'update'])->name('admin.update');
    Route::get('/admin/cp/role',[AdminController::class,'role'])->name('admin.role');
    Route::patch('/users/{id}/active', [AdminController::class, 'active'])->name('admin.users.toggle');
    Route::get('/admin/users/search', [AdminController::class, 'search'])->name('admin.search');

    Route::get('/areas',[AreaController::class,'areas']);
    Route::get('/areas/delete/{id}',[AreaController::class,'delete']);
    Route::post('/areas/edit/{id}',[AreaController::class,'edit']);
    Route::post('/areas/add',[AreaController::class,'add']);

    Route::get('/tools',[ToolController::class,'tools']);
    Route::get('/tools/delete/{id}',[ToolController::class,'delete']);
    Route::post('/tools/edit/{id}',[ToolController::class,'edit']);
    Route::post('/tools/add',[ToolController::class,'add']);


    Route::get('/services',[ServiceController::class,'services']);
    Route::get('/services/delete/{id}',[ServiceController::class,'delete']);
    Route::post('/services/edit/{id}',[ServiceController::class,'edit']);
    Route::post('/services/add',[ServiceController::class,'add']);
    Route::post('/services/toggle-active/{id}', [ServiceController::class, 'toggleActive']);


    Route::get('/grades',[GradeController::class,'grades']);
    Route::get('/grades/delete/{id}',[GradeController::class,'delete']);
    Route::post('/grades/edit/{id}',[GradeController::class,'edit']);
    Route::post('/grades/add',[GradeController::class,'add']);


    Route::get('/disability causes',[DisabilityCauseController::class,'disabilitycauses']);
    Route::get('/disability causes/delete/{id}',[DisabilityCauseController::class,'delete']);
    Route::post('/disability causes/edit/{id}',[DisabilityCauseController::class,'edit']);
    Route::post('/disability causes/add',[DisabilityCauseController::class,'add']);


    Route::get('/disability types',[DisabilityTypeController::class,'disabilitytypes']);
    Route::get('/disability types/delete/{id}',[DisabilityTypeController::class,'delete']);
    Route::post('/disability types/edit/{id}',[DisabilityTypeController::class,'edit']);
    Route::post('/disability types/add',[DisabilityTypeController::class,'add']);

    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::get('posts/{id}/toggle-active', [PostController::class, 'toggleActive'])->name('posts.toggleActive');
//هان اسماء الرواتس
    Route::get('/posts/add', [PostController::class, 'create'])->name('posts.index');
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.create');



});

Route::middleware(['employee'])->group(function () {

    Route::get('/employee/cp', [EmployeeController::class, 'employee'])->name('employee');

    Route::get('/employee/exemption', [PatientAssistiveToolController::class, 'exemption'])->name('exemption');
    Route::get('/employee/exemptions', [PatientAssistiveToolController::class, 'exemption2'])->name('exemption2');
    Route::post('/employee/exemption/source/{id}', [PatientAssistiveToolController::class, 'source'])->name('exemption.source');
    Route::post('/employee/price/{id}', [PatientAssistiveToolController::class, 'value'])->name('exemption.price');

    Route::get('/employee/filter/disability', [EmployeeController::class, 'filterByDisability'])->name('employee.filter');
    Route::get('/employee/filter/area', [EmployeeController::class, 'filterByarea'])->name('employee.filter2');
    Route::get('/patients/{id}', [EmployeeController::class, 'show'])->name('patients.show');


});



Route::middleware(['employee_services'])->group(function () {

    Route::get('/employee_s/cp', [UserController::class, 'employee_s'])->name('employee_s');
    Route::get('/employee_s/service', [EmployeeServicesController::class, 'service'])->name('employee.service');

    Route::get('/employee_s/service/done', [EmployeeServicesController::class, 'service_done'])->name('employee.service done');

    Route::post('/provided-services/{id}/start', [EmployeeServicesController::class, 'start'])->name('provided_service.start');
    Route::post('/provided-services/{id}/complete', [EmployeeServicesController::class, 'complete'])->name('provided_service.complete');


    Route::resource('available-appointments', AvailableAppointmentController::class);
    Route::get('/available-appointments', [AvailableAppointmentController::class, 'index'])->name('appointment.index');
    Route::get('/available-appointments/create', [AvailableAppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/available-appointments', [AvailableAppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/available-appointments/{id}/edit', [AvailableAppointmentController::class, 'edit'])->name('appointment.edit');
    Route::put('/available-appointments/{id}', [AvailableAppointmentController::class, 'update'])->name('appointment.update');
    Route::delete('/available-appointments/{id}', [AvailableAppointmentController::class, 'destroy'])->name('appointment.destroy');

    Route::post('/notes/store/{patientId}', [NoteController::class, 'store'])->name('notes.store');
    Route::put('/notes/update/{patientId}/{noteId}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/delete/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');


   Route::get('/employee/search', [NoteController::class, 'searchPatients'])->name('search-patient');
    Route::match(['get', 'post'], '/employee/notes/{id}', [NoteController::class, 'showPatient'])->name('showPatient');
    Route::delete('/employee-reports/{id}', [MedicalReportController::class, 'destroy2'])->name('patient.reports.destroy2');
    Route::get('/my-reports/generate/{id}', [MedicalReportController::class, 'generate'])->name('patient.reports.generate');
    Route::get('/my-reports/show', [MedicalReportController::class, 'index'])->name('patient.reports.index');

});


Route::get('/', [PostController::class, 'welcome'])->name('news');



Route::get('/locale/{locale}', [langcontroller::class, 'setLocale']);

Route::get('/donations', [PostController::class, 'donation'])->name('donations.index');
Route::get('/donations/{id}', [PostController::class, 'show'])->name('donations.show');
Route::get('/achievement', [PostController::class, 'event'])->name('achievement.index');


Route::middleware(['role:employee,employee_services'])->group(function () {
    Route::get('/employee/patient/{id}/view', [EmployeeController::class, 'show'])->name('employee.patient.view');
});

Route::middleware(['role:admin,patient,employee,employee_services'])->group(function () {
    Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
    Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');

});
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->middleware('throttle:3,1')->name('password.update');


Route::get('/index', function () {return view('index');});

Route::get('/about', function () {return view('about');});

Route::get('/support', function () {return view('support');});

Route::get('/contact', function () {return view('contact');});

Route::get('/activity', function () {return view('activity');});




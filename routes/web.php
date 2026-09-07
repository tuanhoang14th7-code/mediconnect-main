<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorSearchController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentBookingController;
use App\Http\Controllers\AppointmentManagementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MedicalContentController;
use App\Http\Controllers\ContactController;


// ================ Patient Register Router's ================
Route::get('/register', function () {
    return view('registerPage');
});
Route::post('/registerNow', [AuthController::class, 'registerProcess']);


// ================ Global Login & Logout Router's ================
Route::get('/login', function () {
    return view('loginPage');
});
Route::post('/loginNow', [AuthController::class, 'loginProcess']);
Route::get('/Admin/AdminDashboard', [AdminController::class, 'dashboard'])->middleware(['isAdmin']);
Route::get('/Patient/PatientDashboard', [PatientController::class, 'dashboard'])->middleware(['isPatient']);
Route::get('/Doctor/DoctorDashboard', [DoctorController::class, 'dashboard'])->middleware(['isDoctor']);
Route::get('/logout', [AuthController::class, 'logoutProcess']);


// Forgot Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

// Reset Password
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');



Route::middleware(['isAdmin'])->group(function () {
    // ================ Admin Router's ================
    // ------ Admin Patients Control Router's ------
    Route::get('Admin/Patients', [AdminController::class, 'patientList']);
    Route::get('Admin/Patient/DeleteThis/{id}', [AdminController::class, 'deleteThisPatient']);

    // ------ Admin Doctor Control Router's ------
    Route::get('Admin/DoctorRegister', function () {
        return view('admin.AdminDoctorRegister');
    });
    Route::post('Admin/RegisterThisDoctorNow', [AdminController::class, 'registerDoctor']);
    Route::get('Admin/Doctors', [AdminController::class, 'doctorsList']);
    Route::get('Admin/DoctorProfile/{id}', [AdminController::class, 'getThisDoctorProfile']);
    Route::get('Admin/Doctor/DeleteThis/{id}', [AdminController::class, 'deleteThisDoctor']);
    Route::get('Admin/AdminDoctorDetailsForm/{id}', [AdminController::class, 'getAddDoctorDetailsFormData']);
    Route::post('Admin/AddThisDoctorDetailsNow', [AdminController::class, 'saveDoctorDetails']);
    Route::get('Admin/Doctor/EditThisProfile/{id}', [AdminController::class, 'getAdminEditDoctorDetailsFormData']);
    Route::post('Admin/Doctor/SaveThisEditedDetailsNow', [AdminController::class, 'saveThisDoctorDetails']);
    Route::post('Admin/Doctor/updateStatus', [AdminController::class, 'updateDoctorStatus']);
    Route::get('Admin/Appointments', [AdminController::class, 'getAppointmentPage']);


    // ------ Admin Appointment Control Router's ------
    Route::post('Admin/Appointment/UpdateStatus', [AdminController::class, 'updateAppointmentStatus']);
});

Route::middleware(['isDoctor'])->group(function () {
    // ================ Doctor Router's ================
    Route::get('Doctor/ShowDoctorDetailsForm', [DoctorController::class, 'doctorCollectDataForm']);
    Route::post('Doctor/SaveDoctorDetailsNow', [DoctorController::class, 'saveDoctorDetails']);
    Route::get('Doctor/MyProfile', [DoctorController::class, 'getDoctorProfile']);
    Route::get('Doctor/EditProfile/{id}', [DoctorController::class, 'getEditDoctorForm']);
    Route::post('Doctor/SaveEditedInformationNow', [DoctorController::class, 'saveEditedDoctorDetails']);
    Route::get('Doctor/Delete/{id}', [DoctorController::class, 'deleteDoctor']);
    Route::post('Doctor/Appointment/UpdateStatus', [DoctorController::class, 'updateAppointmentStatus']);
});

Route::middleware(['isPatient'])->group(function () {
    // ================ Patient Router's ================
    Route::get('Patient/MyProfile', [PatientController::class, 'patientProfile']);

    Route::get('Patient/EditProfile', [
        PatientController::class,
        'editPatientForm'
    ]);

    Route::post('Patient/EditProfile', [
        PatientController::class,
        'editPatient'
    ]);
    
    Route::get('Patient/Delete/{id}', [PatientController::class, 'deletePatient']);
    // My Appointments
    Route::get(
        '/Patient/MyAppointments',
        [PatientController::class, 'myAppointments']
    )->name('patient.appointments');


    Route::get(
        '/Patient/Appointments/{id}',
        [PatientController::class, 'appointmentDetail']
    )->name('patient.appointments.show');
    
    Route::post('Patient/Appointment/UpdateStatus', [PatientController::class, 'appointmentCancel']);
    // Doctor Search
    Route::get(
        '/doctors',
        [DoctorSearchController::class, 'index']
    );

    Route::get(
        '/doctors/facilities/{cityId}',
        [DoctorSearchController::class, 'getFacilities']
    );

    Route::get(
        '/doctors/specializations/{facilityId}',
        [DoctorSearchController::class, 'getSpecializations']
    );

    Route::get(
        '/doctors/results',
        [DoctorSearchController::class, 'getDoctors']
    );

    Route::get(
        '/doctors/{assignmentId}/available-dates',
        [DoctorSearchController::class, 'getAvailableDates']
    );

    Route::get(
        '/doctors/{assignmentId}/slots',
        [DoctorSearchController::class, 'getAvailableSlots']
    );

    Route::get(
        '/doctors/{assignmentId}',
        [DoctorSearchController::class, 'show']
    )->name('patient.doctor.show');

    // Appointment Booking
    Route::get(
        '/appointments/confirm/{slotId}',
        [AppointmentBookingController::class, 'confirm']
    )->name('patient.appointment.confirm');


    Route::post(
        '/appointments/book',
        [AppointmentBookingController::class, 'store']
    )->name('patient.appointment.store');

    // Reschedule Appointment
    Route::get(
        '/Patient/Appointments/{id}/Reschedule',
        [
            AppointmentManagementController::class,
            'rescheduleForm'
        ]
    )->name('patient.appointments.reschedule');


    Route::post(
        '/Patient/Appointments/{id}/Reschedule',
        [
            AppointmentManagementController::class,
            'reschedule'
        ]
    )->name('patient.appointments.reschedule.update');

    // Cancel Appointment
    Route::get(
        '/Patient/Appointments/{id}/Cancel',
        [
            AppointmentManagementController::class,
            'cancelForm'
        ]
    )->name('patient.appointments.cancel');


    Route::post(
        '/Patient/Appointments/{id}/Cancel',
        [
            AppointmentManagementController::class,
            'cancel'
        ]
    )->name('patient.appointments.cancel.update');
    // Patient Notifications
    Route::get(
        '/Patient/Notifications',
        [NotificationController::class, 'index']
    )->name('patient.notifications');


    Route::post(
        '/Patient/Notifications/ReadAll',
        [NotificationController::class, 'markAllAsRead']
    )->name('patient.notifications.readAll');


    Route::post(
        '/Patient/Notifications/{id}/Read',
        [NotificationController::class, 'markAsRead']
    )->name('patient.notifications.read');

    // Medical Contents
    Route::get(
        '/Patient/MedicalContents',
        [
            MedicalContentController::class,
            'index'
        ]
    )->name('patient.medical.contents');
    
    Route::get(
    '/Patient/MedicalContents/{slug}',
    [
        MedicalContentController::class,
        'show'
    ]
    )->name('patient.medical.contents.show');
});

// views routers 
Route::get('/doctorDetails/{id}', [LocalController::class, 'getThisDoctorDetails']);

Route::get('FilterDoctors', [LocalController::class, 'getDoctorListForFilter']);
Route::post('getAppointment', [LocalController::class, 'getAppointmentForm']);
Route::post('BookAppointmentNow', [LocalController::class, 'saveAppointment']);
// Route::get('Appointment', [LocalController::class, 'getDoctorListForFilter']);



Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/index', [HomeController::class, 'index']);

Route::get('/index2', function () {
    return view('index2');
});
Route::get('/index3', function () {
    return view('index3');
});
Route::get('/about', function () {
    return view('about');
});
// Contact Us
Route::get(
    '/contact',
    [ContactController::class, 'show']
)->name('contact');


Route::post(
    '/contact',
    [ContactController::class, 'store']
)->name('contact.store');

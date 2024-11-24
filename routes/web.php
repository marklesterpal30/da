<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;


use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserOutgoingController;
use App\Http\Controllers\UserMyDocumentsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserIncomingController;



use App\Http\Controllers\OfficeDashboardController;
use App\Http\Controllers\OfficeIncomingController;
use App\Http\Controllers\OfficeAllDocumentsController;
use App\Http\Controllers\DistributorMasterController;
use App\Http\Controllers\OfficeOutgoingController;
use App\Http\Controllers\OfficeOutgoingDocumentsController;
use App\Http\Controllers\OfficeProfileController;




use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminIncomingController;
use App\Http\Controllers\AdminAllDocumentsController;
use App\Http\Controllers\AdminIncomingInactiveController;
use App\Http\Controllers\AdminOfficeController;
use App\Http\Controllers\AdminPurposeController;
use App\Http\Controllers\AdminRecordsController;
use App\Http\Controllers\AdminOutgoingDocumentsController;
use App\Http\Controllers\AdminOutgoingActiveDocuments;
use App\Http\Controllers\AdminDisposalIncoming;
use App\Http\Controllers\AdminOutgoingInactiveDocuments;
use App\Http\Controllers\AdminCreteDocumentsController;
use App\Http\Controllers\AdminProfileController;








use App\Http\Controllers\FileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/forward-documents', [AdminIncomingController::class, 'forwardDocument']);



Route::get('/login', [AuthController::class, 'showlogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/signupForm', [AuthController::class, 'signupForm']);
Route::post('/signup', [AuthController::class, 'signup']);

Route::get('/verifyForm', [AuthController::class, 'showVerify']);
Route::post('/sendVerification', [AuthController::class, 'sendVerification']);

Route::get('/forgotpassword', [AuthController::class, 'forgotPasswordForm']);
Route::post('/forgotPassword', [AuthController::class, 'forgotPassword']);

Route::get('/resetPasswordForm/{email}', [AuthController::class, 'resetPasswordForm']);


Route::post('/resetPassword', [AuthController::class, 'resetPassword']);



Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/verify/{email}', [AuthController::class, 'verify']);




Route::group(['middleware' => ['auth', 'user']], function () {
    Route::get('/user-dashboard', [UserDashboardController::class, 'showCreatorDashboard']);
    Route::get('/user-outgoing', [UserOutgoingController::class, 'showCreatorOutgoing']);
    Route::resource('/user-incoming', UserIncomingController::class);
    Route::post('/user-incoming-received', [UserIncomingController::class, 'received']);
    Route::resource('/user-mydocuments', UserMyDocumentsController::class);
    Route::get('/user-profile', [UserProfileController::class, 'showCreatorProfile']);
    Route::resource('/creator-file', FileController::class);
    Route::post('/user-changePassword', [UserProfileController::class, 'changePassword']);
});

Route::group(['middleware' => ['auth', 'office']], function () {
    Route::get('/office-dashboard', [OfficeDashboardController::class, 'showDistributorDashboard']);
    Route::resource('/office-incoming', OfficeIncomingController::class);
    Route::resource('/office-alldocuments', OfficeAllDocumentsController::class);
    Route::post('/accept-documents', [OfficeIncomingController::class, 'acceptDocuments']);
    Route::patch('/distributor-return-documents', [OfficeIncomingController::class, 'returnDocuments'])->name('returnDocuments');
    Route::resource('/master', DistributorMasterController::class);
    Route::resource('/office-outgoing', OfficeOutgoingController::class);
    Route::resource('/office-outgoing-documents', OfficeOutgoingDocumentsController::class);
    Route::resource('/office-profile', OfficeProfileController::class);
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'showApproverDashboard']);
    Route::resource('/admin-incoming', AdminIncomingController::class);
    Route::patch('/approved-documents', [AdminIncomingController::class, 'approvedDocuments'])->name('approveddocuments');
    Route::resource('/admin-alldocuments', AdminAllDocumentsController::class);
    Route::resource('/admin-inactiveincoming', AdminIncomingInactiveController::class);
    Route::resource('/admin-employee', AdminOfficeController::class);
    Route::patch('/admin-return-documents', [AdminIncomingController::class, 'returnDocuments']);
    Route::resource('/admin-purpose', AdminPurposeController::class);
    Route::post('/admin-delete-purpose', [AdminPurposeController::class, 'deletePurpose']);
    Route::get('/print/{documentId}', [AdminIncomingInactiveController::class, 'reportInactive']);
    Route::get('/admin-generateReport', [AdminRecordsController::class, 'generateReport']);
    Route::resource('/admin-records', AdminRecordsController::class);
    Route::resource('/admin-outgoing-documents', AdminOutgoingDocumentsController::class);
    Route::resource('/admin-outgoing-active-documents', AdminOutgoingActiveDocuments::class);
    Route::resource('/admin-outgoing-inactive-documents', AdminOutgoingInactiveDocuments::class);
    Route::resource('/admin-disposalincoming', AdminDisposalIncoming::class);
    Route::resource('/admin-createdocuments', AdminCreteDocumentsController::class);
    Route::resource('/admin-profile', AdminProfileController::class);


});



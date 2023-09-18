<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admins\AdminDashboardCOntroller;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MultiFormSubmitController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    /**
    *our Account routes go in here
    */
    Route::resource('sms', SMSController::class)->except(['create', 'show', 'edit']);
    Route::get('messaging/inbound', [SMSController::class, 'webhooks']);

    Route::get('/multi-step-form', [MultiFormSubmitController::class, 'showMultiStepForm']);
    Route::post('/multi-step-submit-form', [MultiFormSubmitController::class, 'submitMultiStepForm']);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * our Roles routes go in here
     */
    Route::resource('roles', RolesController::class)->except(['create', 'show', 'edit']);
    Route::get('role/lists', [RolesController::class, 'lists'])->name('roles.list');
     /**
     * User wise permissions
     */
    Route::get('role/roleWisePermissionList', [RolesController::class, 'roleWisePermissionList'])->name('roles.roleWisePermissionList');

    /**
     * our Permissions routes go in here
     */
    Route::resource('permissions', PermissionController::class)->except(['create', 'show', 'edit']);
    Route::get('permission/lists', [PermissionController::class, 'lists'])->name('permissions.list');

    /**
     * our Permissions routes go in here
     */
    Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);
    Route::get('user/lists', [UserController::class, 'lists'])->name('users.list');

    /**
     * our Packages routes go in here
     */
    Route::resource('packages', PackageController::class)->except(['create', 'show', 'edit']);
    Route::get('package/lists', [PackageController::class, 'lists'])->name('packages.list');

    /**
     * our customers routes go in here
    */
    Route::resource('customers', CustomerController::class)->except(['create', 'show', 'edit']);
    Route::get('customer/lists', [CustomerController::class, 'lists'])->name('customers.list');

    /**
     * our customers routes go in here
    */
    Route::resource('bills', BillController::class)->except(['create', 'show', 'edit']);
    Route::get('bill/lists', [BillController::class, 'lists'])->name('bills.list');
    Route::get('bill/customer-wise-bill/{customer_id}', [BillController::class, 'customerwisebillAmount'])->name('bills.customerwisebill');

    /**
    *our Expense routes go in here
    */
    Route::resource('expenses', ExpenseController::class)->except(['create', 'show', 'edit']);
    Route::get('expense/lists', [ExpenseController::class, 'lists'])->name('expenses.list');

    /**
    *our Account routes go in here
    */
    Route::resource('accounts', AccountController::class)->except(['create', 'show', 'edit']);
    Route::get('account/lists', [AccountController::class, 'lists'])->name('accounts.list');

    /**
    *our Account routes go in here
    */
    Route::resource('transactions', TransactionController::class)->except(['create', 'show', 'edit']);
    Route::get('transaction/lists', [TransactionController::class, 'lists'])->name('transactions.list');

 

});


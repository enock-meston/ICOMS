<?php

use App\Http\Controllers\CoOperative\CoUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\department\DepartmentController;
use App\Http\Controllers\FieldActivityController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InputAllocationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductionPlanController;
use App\Http\Controllers\RiceDeliveryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    $title = "Kwinjira";
    return view('login', compact('title'));
});

// (zip-test route removed after debugging)

// Route::middleware('guest.any')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'loginMethod'])->name('login.post');
// });

// Protected routes - require authentication from either guard
Route::middleware('auth.any')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource("users", UserController::class);
    Route::resource("roles", RoleController::class);

    //co-operative routes
    Route::get('/co-operative/user/create', [CoUserController::class, 'create'])->name('cooperative.user.create');
    Route::get('/co-operative/user', [CoUserController::class, 'index'])->name('cooperative.user');
    Route::post('/co-operative/user', [CoUserController::class, 'store'])->name('cooperative.user.store');
    Route::get('/co-operative/user/{id}/edit', [CoUserController::class, 'edit'])->name('cooperative.user.edit');
    Route::put('/co-operative/user/{id}', [CoUserController::class, 'update'])->name('cooperative.user.update');
    Route::delete('/co-operative/user/{id}', [CoUserController::class, 'destroy'])->name('cooperative.user.destroy');

    // group routes
    Route::get('/group/create', [GroupController ::class, 'create'])->name('group.create');
    Route::get('/group', [GroupController::class, 'index'])->name('group.index');
    Route::post('/group', [GroupController::class, 'store'])->name('group.store');
    Route::get('/group/{id}/edit', [GroupController::class, 'edit'])->name('group.edit');
    Route::put('/group/{id}', [GroupController::class, 'update'])->name('group.update');
    Route::delete('/group/{id}', [GroupController::class, 'destroy'])->name('group.destroy');

    //Season routes
    Route::get('/season/create', [SeasonController ::class, 'create'])->name('season.create');
    Route::get('/season', [SeasonController::class, 'index'])->name('season.index');
    Route::post('/season', [SeasonController::class, 'store'])->name('season.store');
    Route::get('/season/{id}/edit', [SeasonController::class, 'edit'])->name('season.edit');
    Route::put('/season/{id}', [SeasonController::class, 'update'])->name('season.update');
    Route::delete('/season/{id}', [SeasonController::class, 'destroy'])->name('season.destroy');

    // departments routes
    Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
    Route::post('/department', [DepartmentController::class, 'store'])->name('department.store');
    Route::put('/department/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('/department/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');
//plan
    Route::get('/productPlan',[ProductionPlanController::class,'index'])->name('plan.index');
    Route::post('/productPlan/action',[ProductionPlanController::class,'handleAction'])->name('plan.store');
//field activity
    Route::get('/fieldativity',[FieldActivityController::class,'index'])->name('field-activity.index');
    Route::post('/fieldativity/action',[FieldActivityController::class,'handleAction'])->name('field-activity.store');
//member
    Route::get('/member',[MemberController::class,'index'])->name('member.index');
    Route::post('/member/action',[MemberController::class,'handleAction'])->name('members.handleAction');
    Route::get('/members/download-template',[MemberController::class, 'downloadTemplate'])->name('members.downloadTemplate');
    Route::post('/members/import',[MemberController::class, 'import'])->name('members.import');


//input alloction
    Route::get('/allocation',[InputAllocationController::class,'index'])->name('allocation.index');
    Route::post('/allocation/action',[InputAllocationController::class,'handleAction'])->name('allocation.handleAction');
    Route::get('/member/{id}/allocations',[InputAllocationController::class,'getAllocations'])->name('allocation.getAllocations');

    //RiceDelivery
    Route::get('/riceDelivery',[RiceDeliveryController::class,'index'])->name('riceDelivery.index');
    Route::post('/riceDelivery/action',[RiceDeliveryController::class,'handleAction'])->name('riceDelivery.handleAction');
    Route::get('/members/{id}/allocations',[RiceDeliveryController::class,'getAllocations'])->name('allocation.getAllocations');


    // Logout route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

require __DIR__.'/auth.php';

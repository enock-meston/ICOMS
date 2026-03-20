<?php

use App\Http\Controllers\BidController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\TenderEvaluationController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\DecisionController;
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
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    $title = "Kwinjira";
    return view('login', compact('title'));
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'loginMethod'])->name('login.post');

// Protected routes
Route::middleware('auth.any')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource("users", UserController::class);
    Route::resource("roles", RoleController::class);

    // Co-operative routes
    Route::get('/co-operative/user/create',    [CoUserController::class, 'create'])->name('cooperative.user.create');
    Route::get('/co-operative/user',           [CoUserController::class, 'index'])->name('cooperative.user');
    Route::post('/co-operative/user',          [CoUserController::class, 'store'])->name('cooperative.user.store');
    Route::get('/co-operative/user/{id}/edit', [CoUserController::class, 'edit'])->name('cooperative.user.edit');
    Route::put('/co-operative/user/{id}',      [CoUserController::class, 'update'])->name('cooperative.user.update');
    Route::delete('/co-operative/user/{id}',   [CoUserController::class, 'destroy'])->name('cooperative.user.destroy');

    // Group routes
    Route::get('/group/create',    [GroupController::class, 'create'])->name('group.create');
    Route::get('/group',           [GroupController::class, 'index'])->name('group.index');
    Route::post('/group',          [GroupController::class, 'store'])->name('group.store');
    Route::get('/group/{id}/edit', [GroupController::class, 'edit'])->name('group.edit');
    Route::put('/group/{id}',      [GroupController::class, 'update'])->name('group.update');
    Route::delete('/group/{id}',   [GroupController::class, 'destroy'])->name('group.destroy');

    // Season routes
    Route::get('/season/create',    [SeasonController::class, 'create'])->name('season.create');
    Route::get('/season',           [SeasonController::class, 'index'])->name('season.index');
    Route::post('/season',          [SeasonController::class, 'store'])->name('season.store');
    Route::get('/season/{id}/edit', [SeasonController::class, 'edit'])->name('season.edit');
    Route::put('/season/{id}',      [SeasonController::class, 'update'])->name('season.update');
    Route::delete('/season/{id}',   [SeasonController::class, 'destroy'])->name('season.destroy');

    // Department routes
    Route::get('/department',         [DepartmentController::class, 'index'])->name('department.index');
    Route::post('/department',        [DepartmentController::class, 'store'])->name('department.store');
    Route::put('/department/{id}',    [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('/department/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');

    // Production Plan
    Route::get('/productPlan',         [ProductionPlanController::class, 'index'])->name('plan.index');
    Route::post('/productPlan/action', [ProductionPlanController::class, 'handleAction'])->name('plan.store');

    // Field Activity
    Route::get('/fieldativity',         [FieldActivityController::class, 'index'])->name('field-activity.index');
    Route::post('/fieldativity/action', [FieldActivityController::class, 'handleAction'])->name('field-activity.store');

    // Member
    Route::get('/member',                    [MemberController::class, 'index'])->name('member.index');
    Route::post('/member/action',            [MemberController::class, 'handleAction'])->name('members.handleAction');
    Route::get('/members/download-template', [MemberController::class, 'downloadTemplate'])->name('members.downloadTemplate');
    Route::post('/members/import',           [MemberController::class, 'import'])->name('members.import');

    // Committees
    Route::get('/committee',          [CommitteeController::class, 'index'])->name('committee.index');
    Route::post('/committees/action', [CommitteeController::class, 'handleAction'])->name('committees.action');

    // Tenders
    Route::get('/tender',          [TenderController::class, 'index'])->name('tender.index');
    Route::get('/tenders/{id}',    [TenderController::class, 'show'])->name('tenders.show');
    Route::post('/tenders/action', [TenderController::class, 'handleAction'])->name('tenders.action');

    // Tender Evaluations
    Route::get('/tender-evaluation',         [TenderEvaluationController::class, 'index'])->name('tender-evaluation.index');
    Route::post('/tender-evaluation/action', [TenderEvaluationController::class, 'handleAction'])->name('tender-evaluation.action');

    // Suppliers
    Route::get('/supplier',          [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/suppliers/action', [SupplierController::class, 'handleAction'])->name('suppliers.action');

    // Supplier Payments
    Route::get('/supplier-payment',         [SupplierPaymentController::class, 'index'])->name('supplier-payment.index');
    Route::post('/supplier-payment/action', [SupplierPaymentController::class, 'handleAction'])->name('supplier-payment.action');

    // Meetings ✅ old Route::view removed
    Route::get('/meeting',         [MeetingController::class, 'index'])->name('meeting.index');
    Route::post('/meeting/action', [MeetingController::class, 'handleAction'])->name('meeting.action');

    // Decisions ✅ old Route::view removed
    Route::get('/decision',         [DecisionController::class, 'index'])->name('decision.index');
    Route::post('/decision/action', [DecisionController::class, 'handleAction'])->name('decision.action');

    // Input Allocation
    Route::get('/allocation',              [InputAllocationController::class, 'index'])->name('allocation.index');
    Route::post('/allocation/action',      [InputAllocationController::class, 'handleAction'])->name('allocation.handleAction');
    Route::get('/member/{id}/allocations', [InputAllocationController::class, 'getAllocations'])->name('allocation.getAllocations');

    // Rice Delivery
    Route::get('/riceDelivery',             [RiceDeliveryController::class, 'index'])->name('riceDelivery.index');
    Route::post('/riceDelivery/action',     [RiceDeliveryController::class, 'handleAction'])->name('riceDelivery.handleAction');
    Route::get('/members/{id}/allocations', [RiceDeliveryController::class, 'getAllocations'])->name('allocation.getAllocations');

    // Bids
    Route::get('/bid', [BidController::class, 'index'])->name('bid.index');

    // Placeholder pages (no controller needed)
    Route::view('/compost',          'compost.index',          ['title' => 'Compost Management'])->name('compost.index');
    Route::view('/contract',         'contract.index',         ['title' => 'Contracts'])->name('contract.index');
    Route::view('/member-payment',   'member-payment.index',   ['title' => 'Member Payments'])->name('member-payment.index');
    Route::view('/procurement-plan', 'procurement-plan.index', ['title' => 'Procurement Plan'])->name('procurement-plan.index');
    Route::view('/report',           'report.index',           ['title' => 'Reports'])->name('report.index');
    Route::view('/task',             'task.index',             ['title' => 'Tasks'])->name('task.index');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

require __DIR__ . '/auth.php';
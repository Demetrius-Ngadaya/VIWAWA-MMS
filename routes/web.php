<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,DashboardController,MemberController,DuesController,DueCategoryController,DuesPaymentController,ContributionCategoryController,ContributionController,ExpenseController,ReportController};
use App\Http\Controllers\DioceseController;
use App\Http\Controllers\ParishController;
use App\Http\Controllers\SCCController;

Route::get('/', fn()=>redirect()->route('login'));


// Auth
Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login.post');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');


Route::middleware('auth')->group(function(){
Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');


// Members
Route::resource('members', MemberController::class);
Route::get('members-search', [MemberController::class,'search'])->name('members.search');



// Due Categories
Route::resource('due-categories', DueCategoryController::class);

// Due Payments
Route::resource('dues', DuesPaymentController::class);
Route::get('dues/member-summary/{memberId}/{categoryId}', [DuesPaymentController::class, 'getMemberSummary']);
// Contributions

Route::resource('contributions', ContributionController::class);


//  contribution-categories ,the route for all CRUD operations:
Route::resource('contribution-categories', ContributionCategoryController::class);

// Add this route for member contribution summary
Route::get('contributions/member-summary/{memberId}/{categoryId}', [ContributionController::class, 'getMemberSummary'])
    ->name('contributions.member-summary');

// Expenses
Route::resource('expenses', ExpenseController::class)->only(['index','create','store','destroy']);

//Hierachy
Route::resource('dioceses', DioceseController::class);
Route::resource('parishes', ParishController::class);
Route::resource('sccs', SCCController::class);


// Reports
Route::get('reports', [ReportController::class,'index'])->name('reports.index');
Route::get('reports/members', [ReportController::class,'members'])->name('reports.members');
Route::get('reports/financial', [ReportController::class,'financial'])->name('reports.financial');
});
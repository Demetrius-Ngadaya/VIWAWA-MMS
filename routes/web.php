<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,DashboardController,MemberController,DuesController,ContributionCategoryController,ContributionController,ExpenseController,ReportController};


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


// Dues
Route::get('dues', [DuesController::class,'index'])->name('dues.index');
Route::get('dues/create', [DuesController::class,'create'])->name('dues.create');
Route::post('dues', [DuesController::class,'store'])->name('dues.store');


// Contributions
Route::resource('contribution-categories', ContributionCategoryController::class)->only(['index','store','update','destroy']);
Route::resource('contributions', ContributionController::class)->only(['index','create','store','destroy']);


// Expenses
Route::resource('expenses', ExpenseController::class)->only(['index','create','store','destroy']);


// Reports
Route::get('reports', [ReportController::class,'index'])->name('reports.index');
Route::get('reports/members', [ReportController::class,'members'])->name('reports.members');
Route::get('reports/financial', [ReportController::class,'financial'])->name('reports.financial');
});
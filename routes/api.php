<?php

use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Department routes
Route::prefix('departments')->group(function () {
    Route::get('/', [DepartmentController::class, 'index'])->name('departments.index');
    Route::post('/', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/{department}', [DepartmentController::class, 'show'])->name('departments.show');
    Route::get('/{department}/subdepartments', [DepartmentController::class, 'subdepartments'])->name('departments.subdepartments');
    Route::put('/{department}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::patch('/{department}', [DepartmentController::class, 'update'])->name('departments.patch');
    Route::delete('/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
});

// Employee routes
Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
    Route::post('/search', [EmployeeController::class, 'search'])->name('employees.search');
    Route::post('/', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/statistics', [EmployeeController::class, 'statistics'])->name('employees.statistics');
    Route::get('/departments', [EmployeeController::class, 'departments'])->name('employees.departments');
    Route::get('/positions', [EmployeeController::class, 'positions'])->name('employees.positions');
    Route::get('/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::put('/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::patch('/{employee}', [EmployeeController::class, 'update'])->name('employees.patch');
    Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'version' => '1.0.0',
    ]);
});

<?php

use App\Http\Livewire\DepartmentsController;
use App\Http\Livewire\EmployeesController;
use App\Http\Livewire\ProcedenciaController;
use App\Http\Livewire\VacationsController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('departments', DepartmentsController::class)->name('home');
Route::get('employees', EmployeesController::class)->name('home');
Route::get('procedencia', ProcedenciaController::class);
Route::get('vacation', VacationsController::class);


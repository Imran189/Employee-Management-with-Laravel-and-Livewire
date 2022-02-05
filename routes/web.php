<?php

use App\Http\Livewire\City\CityIndexComponent;
use App\Http\Livewire\Country\CountryIndexComponent;
use App\Http\Livewire\Department\DepartmentComponent;
use App\Http\Livewire\Employee\EmployeeIndex;
use App\Http\Livewire\State\StateIndexComponent;
use App\Http\Livewire\User\UserIndexComponent;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/users', UserIndexComponent::class)->name('user.index');
    Route::get('/country', CountryIndexComponent::class)->name('country.index');
    Route::get('/state', StateIndexComponent::class)->name('state.index');
    Route::get('/city', CityIndexComponent::class)->name('city.index');
    Route::get('/department', DepartmentComponent::class)->name('dept.index');
    Route::get('employee', EmployeeIndex::class)->name('employee.index');
});

<?php

use App\Http\Controllers\admin\InwordController;
use App\Http\Controllers\admin\ItemController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\MachineController;
use App\Http\Controllers\admin\OutwordController;
use App\Http\Controllers\admin\OutwordSummaryController;
use App\Http\Controllers\admin\PartyController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\StockController;
use App\Http\Controllers\HomeController;
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
    return view('admin.authentication.login');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:admin', 'PreventBackHistory'])->group(function () {
        Route::get('login', [LoginController::class,'index'])->name('login');
        Route::post('check', [LoginController::class, 'check'])->name('check');
    });
    Route::middleware(['auth:admin', 'PreventBackHistory'])->group(function () {
        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
        Route::resource('inwords', InwordController::class);

        Route::resource('parties', PartyController::class);
        Route::resource('machines', MachineController::class);
        Route::resource('items', ItemController::class);
        Route::resource('stocks', StockController::class);
        Route::resource('settings', SettingController::class);

        Route::get('get-parties', [PartyController::class, 'getData'])->name('get-parties');
        Route::get('get-machines', [MachineController::class, 'getData'])->name('get-machines');
        Route::get('get-items', [ItemController::class, 'getData'])->name('get-items');
        Route::get('get-stocks', [StockController::class, 'getData'])->name('get-stocks');

        Route::post('get-quantity',[OutwordController::class,'getQuantity'])->name('get-quantity');
        Route::resource('outwords', OutwordController::class);
        Route::resource('outwords-summary', OutwordSummaryController::class);

        Route::get('get-outwords', [OutwordController::class, 'getData'])->name('get-outwords');

        Route::get('get-inwords-reports', [InwordController::class, 'getData'])->name('get-inwords-reports');
        Route::get('get-outwords-summary', [OutwordSummaryController::class, 'getData'])->name('get-outwords-summary');
        Route::get('get-total-sum', [OutwordSummaryController::class, 'getSum'])->name('get-total-sum');

        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    });
});

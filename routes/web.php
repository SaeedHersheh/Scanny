<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VendingMachineController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Auth;

// Redirect root URL to QR page
Route::get('/', function () {
    return redirect('/machine/1/qr');
});

// Auth Routes
Route::get('/scanny', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');

// HOME PAGE (requires login)
Route::get('/home', function () {
    $machine = \App\Models\VendingMachine::with('items')->find(1);

    return view('states.home', [
        'machine' => $machine,
        'items'   => $machine ? $machine->items : []
    ]);
})->name('home')->middleware('auth');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// QR Page
Route::get('/machine/{id}/qr', [VendingMachineController::class, 'qr'])->name('machine.qr');

// Protected vending routes
Route::middleware('auth')->group(function() {
    Route::get('machine/{id}', [VendingMachineController::class, 'show'])->name('machine.show');
    Route::post('machine/add', [VendingMachineController::class, 'addToCart'])->name('machine.add');
    Route::post('machine/buy', [VendingMachineController::class, 'buy'])->name('machine.buy');
    Route::post('/add-balance', [VendingMachineController::class, 'addBalance'])->name('balance.add');
});

// State Routes
Route::get('/states', [StateController::class, 'statesView'])->name('state.view');
// Route::get('/state/login', [StateController::class, 'loginStateView'])->name('state.login.view');
// Route::get('/state/cart', [StateController::class, 'cartStateView'])->name('state.cart.view');

// Register/Login main page
Route::get('/main', function () {
    return view('states.main');
})->name('main.page');

// BALANCE PAGE — PUBLIC OR PROTECTED?
Route::get('/state/balance', function () {
    return view('states.balance');
})->name('state.balance');


Route::get('/logoutToMain', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('main.page');
})->name('logout.main');

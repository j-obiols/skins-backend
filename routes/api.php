<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\SkinController;
use App\Http\Controllers\api\UserSkinController;
use Illuminate\Support\Facades\Mail;

use App\Mail\PaymentMailable;


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


Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/skins/available', [SkinController::class, 'availableSkins'])->name('skins.available');

Route::middleware(['auth:api'])->group(function() {

    Route::post('/skins/buy', [SkinController::class, 'buy'])->name('skins.buy');

    Route::get('/skins/myskins', [SkinController::class, 'getSkins'])->name('skins.get');

    Route::put('/skins/color', [SkinController::class, 'updateColor']) -> name('skins.color');

    Route::post('/skins/gadget', [SkinController::class, 'updateGadget']) -> name('skins.gadget');

    Route::delete('/skins/delete/{id}', [SkinController::class, 'destroy'])->name('skins.delete');

    Route::get('/skin/getskin/{id}', [SkinController::class, 'show'])->name('skin.show');

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    
});
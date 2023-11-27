<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
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

Route::prefix('pets')->group(function () {
    Route::get('/findByStatus', [PetController::class, 'findByStatus'])->name('pets.findByStatus');
    Route::get('/findById', [PetController::class, 'findById'])->name('pets.findById');
    Route::post('/add-pet', [PetController::class, 'addPet'])->name('pets.addPet');
    Route::put('/update-pet', [PetController::class, 'updatePet'])->name('pets.updatePet');
    Route::post('/add-image-pet', [PetController::class, 'addImagePet'])->name('pets.addImagePet');
    Route::delete('/delete-pet', [PetController::class, 'deletePet'])->name('pets.deletePet');
});

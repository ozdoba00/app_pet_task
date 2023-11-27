<?php

use App\Http\Controllers\PetController;

Route::get('/find-pets-by-status', [PetController::class, 'showFindPetsByStatusForm'])->name('formPetByStatus');
Route::get('/find-pets-by-id', [PetController::class, 'showFindPetsByIdForm'])->name('formPetById');
Route::get('/add-pet', [PetController::class, 'showAddPetForm'])->name('formAddPet');
Route::get('/update-pet', [PetController::class, 'showUpdatePetForm'])->name('formUpdatePet');
Route::get('/add-image-pet', [PetController::class, 'showAddImagePetForm'])->name('formAddImagePet');
Route::get('/delete-pet', [PetController::class, 'showDeletePetForm'])->name('formDeletePet');

Route::get('/', function(){
    return view('index');
})->name('index');
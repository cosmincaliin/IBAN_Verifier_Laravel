<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/validate-iban', 'validate_iban');
Route::post('/valida-iban', [BankController::class, 'validateIBAN']);

Route::view('/discover-iban', 'discover_iban');
Route::post('/descubre-iban', [BankController::class, 'discoverIBAN']);

Route::get('/valida-ccc/{ccc}', 'BankController@validaCCC');

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/valida-iban/{iban}', 'BankController@validaIBAN');
Route::get('/valida-ccc/{ccc}', 'BankController@validaCCC');
Route::get('/descubre-iban/{iban}', 'BankController@descobreixIBAN');


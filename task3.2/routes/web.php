<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'WordsTextController@index')->name('index');
Route::get('/addtext', 'WordsTextController@addText');
Route::get('/words/{oneText}', 'WordsTextController@oneText');
Route::post('/addwords', 'WordsTextController@addWords')->name('addwords');


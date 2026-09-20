<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('/login', fn () => redirect()->to(Filament::getLoginUrl()))->name('login');

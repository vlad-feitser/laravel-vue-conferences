<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;


Route::get('{page}', 'MainController')->where('page', '.*');

Auth::routes();



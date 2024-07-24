<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DestinationController;

Route::get('/destinations', [DestinationController::class, 'index']);

<?php

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/cities/{provinceId}', function ($provinceId) {
    return City::where('province_id', $provinceId)->get();
});

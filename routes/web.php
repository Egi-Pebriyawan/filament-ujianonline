<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\TryoutOnline;

//jalan menuju url tryout
Route::group(['middleware' => 'auth'], function ()
//merujuk ke pages ke file TryoutOnline.php
{ Route::get('/do-ujian/{packageId}', TryoutOnline::class)->name('do-ujian');
});


//Route untuk login 
// Route::get('/login', function(){
//     return redirect ('admin/login');
// })->name('login')

Route::get('/', function () {
    return view('welcome');
});

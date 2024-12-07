<?php


use App\Livewire\TryoutOnline;
use Illuminate\Support\Facades\Route;

//jalan menuju url tryout
Route::group(['middleware' => 'auth'], function ()
{ Route::get('/do-tryout/{id}', TryoutOnline::class)->name('do-tryout');
});


//Route untuk login 
// Route::get('/login', function(){
//     return redirect ('admin/login');
// })->name('login')

Route::get('/', function () {
    return view('welcome');
});

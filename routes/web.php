<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('tenant')->group(function () {
    Route::get('/', function () {
        return 'hi' . auth()->user()->name;
    });
});

// Route::domain('{tenant}.localhost')->middleware('tenant')->group(function(){
//     Route::prefix('owner')->middleware(['auth', 'owner'])->group(function () {
//         Route::get('/Entries/edit/{id}',function($id){
//             echo $id;
//         });
//     });
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

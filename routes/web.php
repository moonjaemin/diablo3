<?php

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
//main
Route::get('/', 'D3Controller@index')->name('home');

//profile, hero
Route::prefix('profile')->group(function () {
    Route::get('{server}/{battleTag}', 'D3Controller@profile');
    Route::get('{server}/{battleTag}/hero/{heroId}', 'D3Controller@hero');
});

//calc
Route::prefix('calc')->group(function () {
    Route::match(['get', 'post'], 'weapon', 'D3Controller@weapon')->name('weapon');
    Route::get('cooldown', 'D3Controller@coolDown')->name('cooldown');
});

//item
Route::post('item', 'D3Controller@item');


///test
Route::post('makeboy', 'D3Controller@makeboy');

//rank
Route::prefix('rank')->group(function () {
    Route::get('{server}/{type}/{seasonal}/{class}/{gameType?}', 'D3Controller@rank');
});

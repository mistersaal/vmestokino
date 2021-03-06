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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', 'LoginController@login')->name('login');

Route::middleware('auth.vk')->group(function () {
    Route::get('/room', 'RoomController@index')->name('own-room');
    Route::get('/room/{room}', 'RoomController@get')->name('room');
    Route::get('/room/{room}/check', 'RoomController@check')->name('room');
    Route::post('/room', 'RoomController@create')->name('room.create');
    Route::put('/room', 'RoomController@update')->name('room.update');
    Route::delete('/room', 'RoomController@delete')->name('room.delete');

    Route::post('/room/{id}/start', 'PlayerController@start')->name('room.event.start');
    Route::post('/room/{id}/buffering', 'PlayerController@buffering')->name('room.event.buffering');
    Route::post('/room/{id}/stop', 'PlayerController@stop')->name('room.event.stop');
    Route::post('/room/{id}/sync','PlayerController@sync')->name('room.event.sync');

    Route::post('/room/{id}/message', 'ChatController@send')->name('room.chat.message');
});

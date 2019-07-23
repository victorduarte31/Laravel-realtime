<?php

//Somente tem acesso quem estiver autenticado
Route::group(['middleware' => 'auth'], function () {

    Route::get('chat', 'Chat\ChatController@index')->name('chat');

    Route::post('chat/message', 'Chat\ChatController@store');

    Route::get('chat/messages', 'Chat\ChatController@messages');

    Route::get('meu-perfil', 'USer\UserController@profile')->name('profile');

    Route::post('atualizar-perfil', 'USer\UserController@profileUpdate')->name('profile.update');
});




Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

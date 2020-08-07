<?php
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:api'
])->namespace('Hanoivip\Chat\Controllers')
    ->prefix('api')
    ->group(function () {
    Route::get('/chat/new', 'ChatController@statNew');
    Route::get('/chat/messages', 'ChatController@fetchMessages');
    Route::post('/chat/send', 'ChatController@sendMessage');
    Route::post('/chat/read', 'ChatController@markRead');
});
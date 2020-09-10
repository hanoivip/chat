<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
    'admin'
])->namespace('Hanoivip\Chat\Controllers')
->prefix('ecmin')
->group(function () {
    // Support vip players
    Route::get('/messages', 'AdminController@messages')->name('ecmin.messages');
});
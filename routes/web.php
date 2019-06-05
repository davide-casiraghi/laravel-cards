<?php

    Route::group(['namespace' => 'DavideCasiraghi\LaravelCards\Http\Controllers', 'middleware' => 'web'], function () {

        /* Cards */
        Route::resource('laravel-cards', 'CardController');

        /* Card translations */
        Route::get('laravel-cards-translation/{imageId}/{languageCode}/create', 'CardTranslationController@create')->name('laravel-cards-translation.create');
        Route::get('laravel-cards-translation/{imageId}/{languageCode}/edit', 'CardTranslationController@edit')->name('laravel-cards-translation.edit');
        Route::resource('laravel-cards-translation', 'CardTranslationController')->except(['create', 'edit']);
    });

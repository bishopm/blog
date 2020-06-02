<?php

Route::group(['middleware' => 'web'], function () {
    Route::get('/login', ['uses' => 'Bishopm\Blog\Http\Controllers\Auth\LoginController@showLoginForm','as' => 'login']);
    Route::post('/login', ['uses' => 'Bishopm\Blog\Http\Controllers\Auth\LoginController@login','as' => 'dologin']);
    Route::get('/logout', ['uses' => 'Bishopm\Blog\Http\Controllers\Auth\LoginController@logout','as' => 'logout']);
    Route::post('/password/email', ['uses' => 'Bishopm\Blog\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail','as' => 'password.email']);
    Route::get('/password/reset', ['uses' => 'Bishopm\Blog\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm','as' => 'password.request']);
    Route::post('/password/reset', ['uses' => 'Bishopm\Blog\Http\Controllers\Auth\ResetPasswordController@reset','as' => 'doreset']);
    Route::get('/password/reset/{token}', ['uses' => 'Bishopm\Blog\Http\Controllers\Auth\ResetPasswordController@showResetForm','as' => 'password.reset']);
    Route::get('register', ['uses'=>'Bishopm\Blog\Http\Controllers\Auth\RegisterController@showRegistrationForm','as'=>'registrationform']);
    Route::post('register', ['uses'=>'Bishopm\Blog\Http\Controllers\Auth\RegisterController@register','as'=>'register']);

    if (env('APP_ENV')=="production") {
        Route::group(array('domain' => '{username}.bishop.net.za'), function ($username) {
            Route::get('/feed', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@feed','as'=>'blogs.feed']);
            Route::post('/search', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@search','as'=>'blogs.search']);
            Route::group(['middleware' => 'auth'], function () {
                // Settings
                Route::get('/settings', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@index','as'=>'settings.index']);
                Route::get('/settings/create', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@create','as'=>'settings.create']);
                Route::get('/settings/{setting}/edit', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@edit','as'=>'settings.edit']);
                Route::get('/settings/{setting}', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@show','as'=>'settings.show']);
                Route::put('/settings/{setting}', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@update','as'=>'settings.update']);
                Route::post('/settings', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@store','as'=>'settings.store']);
                Route::delete('/settings/{setting}', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@destroy','as'=>'settings.destroy']);

                Route::get('/blogs', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@index','as'=>'blogs.index']);
                Route::get('/blogs/create', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@create','as'=>'blogs.create']);
                Route::get('/blogs/{blog}/edit', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@edit','as'=>'blogs.edit']);
                Route::put('/blogs/{blog}', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@update','as'=>'blogs.update']);
                Route::post('/blogs', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@store','as'=>'blogs.store']);
                Route::delete('/blogs/{blog}', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@destroy','as'=>'blogs.destroy']);
                Route::get('/blogs/addtag/{blog}/{tag}', ['uses' => 'Bishopm\Blog\Http\Controllers\BlogsController@addtag','as' => 'blogs.addtag']);
                Route::get('/blogs/removetag/{blog}/{tag}', ['uses' => 'Bishopm\Blog\Http\Controllers\BlogsController@removetag','as' => 'blogs.removetag']);
                Route::get('/blogs/{blog}/removemedia', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@removemedia','as'=>'blogs.removemedia']);
            });
            // Tags
            Route::get('/subject/{tag}', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@subject','as'=>'blogs.subject']);

            Route::get('/', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@display','as'=>'blogs.display']);
            Route::get('/{year}/{month}/{slug}', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@show','as'=>'blogs.show']);
        });
        Route::get('/', ['uses' => 'Bishopm\Blog\Http\Controllers\HomeController@home','as' => 'home']);
    } else {
        Route::get('/', ['uses' => 'Bishopm\Blog\Http\Controllers\HomeController@home','as' => 'home']);
        Route::get('/{username}', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@display','as'=>'blogs.display']);
        Route::get('{username}/feed', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@feed','as'=>'blogs.feed']);
        Route::post('/{username}/search', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@search','as'=>'blogs.search']);
        Route::group(['middleware' => 'auth'], function () {
            // Blogs
            Route::get('/{username}/blogs', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@index','as'=>'blogs.index']);
            Route::get('/{username}/blogs/create', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@create','as'=>'blogs.create']);
            Route::get('/{username}/blogs/{blog}/edit', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@edit','as'=>'blogs.edit']);
            Route::put('/{username}/blogs/{blog}', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@update','as'=>'blogs.update']);
            Route::post('/{username}/blogs', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@store','as'=>'blogs.store']);
            Route::delete('/{username}/blogs/{blog}', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@destroy','as'=>'blogs.destroy']);
            Route::get('/{username}/blogs/addtag/{blog}/{tag}', ['uses' => 'Bishopm\Blog\Http\Controllers\BlogsController@addtag','as' => 'blogs.addtag']);
            Route::get('/{username}/blogs/removetag/{blog}/{tag}', ['uses' => 'Bishopm\Blog\Http\Controllers\BlogsController@removetag','as' => 'blogs.removetag']);
            Route::get('/{username}/blogs/{blog}/removemedia', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@removemedia','as'=>'blogs.removemedia']);

            // Settings
            Route::get('/{username}/settings', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@index','as'=>'settings.index']);
            Route::get('/{username}/settings/create', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@create','as'=>'settings.create']);
            Route::get('/{username}/settings/{setting}/edit', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@edit','as'=>'settings.edit']);
            Route::get('/{username}/settings/{setting}', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@show','as'=>'settings.show']);
            Route::put('/{username}/settings/{setting}', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@update','as'=>'settings.update']);
            Route::post('/{username}/settings', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@store','as'=>'settings.store']);
            Route::delete('/{username}/settings/{setting}', ['uses'=>'Bishopm\Blog\Http\Controllers\SettingsController@destroy','as'=>'settings.destroy']);
        });
        // Tags
        Route::get('/{username}/subject/{tag}', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@subject','as'=>'blogs.subject']);
        Route::get('/{username}/{year}/{month}/{slug}', ['uses'=>'Bishopm\Blog\Http\Controllers\BlogsController@show','as'=>'blogs.show']);
    }
});

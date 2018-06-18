<?php
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('login', 'LoginController@index')->name('login');
    Route::post('login', 'LoginController@signIn');

    Route::group(['middleware' => 'guest:web'], function () {
        Route::get('logout', 'LoginController@logout')->name('logout');
        Route::get('/', 'IndexController@index');
        Route::get('index', 'IndexController@index')->name('index');
        Route::get('forbidden', 'IndexController@forbidden')->name(403);
        Route::put('cache', 'IndexController@flushCache')->name('cache.flush');
        Route::delete('cache', 'IndexController@cleanCache')->name('cache.clean');
        Route::get('first', 'IndexController@first')->name('first');

        Route::group(['middleware' => 'rbac'], function () {
            Route::resource('user', 'UsersController', ['except' => ['show', 'destroy']]);
            Route::put('user/{user}', 'UsersController@update')->name('user.update');
            Route::patch('user/{user}', 'UsersController@updateStatus')->name('user.active');
            Route::get('user/{user}/password', 'UsersController@editPwd')->name('user.safe');
            Route::patch('user/{user}/password', 'UsersController@updatePwd')->name('user.safe');

            Route::resource('rule', 'RulesController', ['except' => ['show']]);
            Route::resource('role', 'RolesController', ['except' => ['show', 'create', 'edit']]);
            Route::get('role/{role}/rule', 'RolesController@setRules')->name('role.set');
            Route::patch('role/{role}/rule', 'RolesController@settedRules')->name('role.setted');
        });

    });
    Route::get('test', 'TestController@test')->name('test');
});

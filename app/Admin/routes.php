<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('users', 'UserController');
    $router->resource('posts', 'PostController');
    $router->resource('comments', 'CommentController');
    $router->resource('thumbs', 'ThumbController');
    $router->resource('notices', 'NoticeController');
    $router->resource('user-reports', 'UserReportController');

    $router->resource('activities', 'ActivityController');

    $router->get('system', 'SystemController@index')->name('admin.system');
});

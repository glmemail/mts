<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    // $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('/', 'ChartjsController@index')->name('admin.chartjs');
    $router->resource('users', UserController::class);
    $router->resource('message', MessageController::class);
    $router->resource('message_list', MessagelistController::class);
    $router->resource('mail', MailController::class);
    $router->get('/mailList/{fluentd_id}', 'MailController@mailList')->name('admin.mailList');
    $router->resource('wechat', WechatController::class);
    $router->resource('phone', PhoneController::class);
    $router->get('/chartjs', 'ChartjsController@index')->name('admin.chartjs');
    $router->get('/chartjs/{fluentd_id}', 'ChartjsController@combaction')->name('admin.chartjsid');
    $router->resource('action', ActionController::class);
    $router->resource('member', MemberController::class);
});

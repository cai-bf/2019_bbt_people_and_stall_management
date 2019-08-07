<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings', 'permission']
], function($api) {
    // login
    $api->post('authorizations', 'AuthorizationsController@login')->name('authorizations.login');

    $api->group([
        'middleware' => ['jwt.auth', 'api.throttle'],
        'limit' => 60,
        'expires' => 1
    ], function($api) {
        // token
        $api->put('authorizations', 'AuthorizationsController@refresh')->name('authorizations.refresh');
        $api->delete('authorizations', 'AuthorizationsController@logout')->name('authorizations.logout');
        // user
        $api->get('user', 'UsersController@get_user')->name('users.get_user');
        $api->post('users', 'UsersController@store')->name('users.store');
        $api->put('user/password', 'UsersController@updatePassword')->name('users.updatePassword');
    });
});
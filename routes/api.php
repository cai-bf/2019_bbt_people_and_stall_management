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
], function ($api) {
    // login
    $api->post('authorizations', 'AuthorizationsController@login')->name('authorizations.login');
    // send psd reset captcha
    $api->post('psd_reset/captcha', 'UsersController@sendPsdResetCaptcha')->name('users.psd_captcha');
    // reset password
    $api->post('reset_password', 'UsersController@resetPsd')->name('users.reset_psd');

    $api->group([
        'middleware' => ['jwt.auth', 'api.throttle'],
        'limit' => 60,
        'expires' => 1
    ], function ($api) {
        // token
        $api->put('authorizations', 'AuthorizationsController@refresh')->name('authorizations.refresh');
        $api->delete('authorizations', 'AuthorizationsController@logout')->name('authorizations.logout');

        // user
        $api->get('users', 'UsersController@index')->name('users.index');
        $api->get('users/myDepartment', 'UsersController@getDepartment')->name('users.department');
        $api->get('users/myGroup', 'UsersController@getGroup')->name('users.group');
        $api->get('user/{id?}', 'UsersController@get_user')->name('users.get_user');
        $api->put('user/{id}', 'UsersController@update')->name('users.update');
        $api->post('users', 'UsersController@store')->name('users.store');
        $api->delete('user/{user}', 'UsersController@delete')->name('users.delete');
        $api->post('users/recycle/{id}', 'UsersController@recycle')->name('users.recycle');
        $api->put('user/update/password', 'UsersController@updatePassword')->name('users.updatePassword');
        $api->post('user/email/captcha', 'UsersController@sendChangeEmailCaptcha')
            ->name('users.email_captcha');
        $api->post('user/email', 'UsersController@resetEmail')->name('users.reset_email');
        $api->get('users/search', 'UsersController@search')->name('users.search');
        // detail
        $api->post('users/avatar', 'DetailController@uploadAvatar')->name('details.avatar');
        $api->post('users/detail', 'DetailController@update')->name('details.update');
        // recycle
        $api->get('users/recycle', 'UsersController@recycleIndex')->name('users.recycleIndex');

        // BBT library
        $api->get('bbt/library', 'UsersController@BBTLibrary')->name('bbt.library');

        // department
        $api->get('departments/index', 'DepartmentsController@index')->name('departments.index');
        $api->post('departments', 'DepartmentsController@create')->name('departments.create');
        $api->put('departments/{department}', 'DepartmentsController@update')->name('departments.update');
        $api->delete('departments/{department}', 'DepartmentsController@delete')->name('departments.delete');

        // group
        $api->get('groups/index', 'GroupsController@index')->name('groups.index');
        $api->post('groups', 'GroupsController@create')->name('groups.create');
        $api->put('groups/{group}', 'GroupsController@update')->name('groups.update');
        $api->delete('groups/{group}', 'GroupsController@delete')->name('groups.delete');

        // college
        $api->get('colleges', 'CollegesController@index')->name('colleges.index');




        // Stall api

        // Calendar
        $api->post('stall/calendar/new', 'CalendarController@newCalendar')->name('calendar.new');
        $api->delete('stall/calendar/delete/{year}/{term}', 'CalendarController@deleteCalendar')->name('calendar.delete');
        $api->put('stall/calendar/update/{year}/{term}', 'CalendarController@updateCalendar')->name('calendar.update');
        $api->get('stall/calendar/show/{year?}/{term?}', 'CalendarController@showCalendar')->name('calendar.show');



        // Schedule
        $api->post('stall/schedule/store', 'ScheduleController@store')->name('schedule.store');
        $api->get('stall/schedule/show/{id}', 'ScheduleController@show')->name('schedule.show');
        $api->put('stall/schedule/check/{id}', 'ScheduleController@check')->name('schedule.check');
        $api->post('stall/schedule/upload', 'ScheduleController@uploadPic')->name('schedule.upload');
        $api->get('stall/schedule/uncheck', 'ScheduleController@showUnCheck')->name('schedule.uncheck');

        //show user's stall task number
        $api->get('stall/number','ScheduleController@showNumber')->name('number.show');

        // Stall
        $api->post('stall/new', 'StallController@newStall')->name('stall.new');
        $api->delete('stall/delete/{id}', 'StallController@deleteStall')->name('stall.delete');
        $api->put('stall/update/{id}', 'StallController@updateStall')->name('stall.update');
        $api->get('stall/show/{id?}', 'StallController@showStall')->name('stall.show');
        $api->get('stall/export/{id}', 'StallController@export')->name('stall.export');

        // Stall task
        $api->post('stall/task/new','StallTaskController@newTask')->name('task.new');
        $api->delete('stall/task/delete/{id}','StallTaskController@deleteTask')->name('task.delete');
        $api->get('stall/task/show/{id}','StallTaskController@showTask')->name('task.show');
        $api->get('stall/task/showlist/{id}','StallTaskController@showTaskList')->name('task.showList');
        $api->get('stall/task/member/{id}','StallTaskController@showTaskMember')->name('task.showMember');
        $api->put('stall/task/check/{id}','StallTaskController@checkIn')->name('task.check');
        $api->post('stall/task/add/{id}','StallTaskController@addTaskAdmin')->name('task.add');
        $api->delete('stall/task/deleteadmin/{id}','StallTaskController@deleteTaskAdmin')->name('task.delete_admin');
        $api->post('stall/task/create','StallTaskController@createList')->name('task.create');
        
        
    });
});

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    // app('cache')->put('aaa','111',60);
    $data = app('cache')->get('aaa');
    dd($data);
    return $router->app->version();
});
/*$router->post('/login','ExampleController@login');
$router->get('/logout','ExampleController@logout');
$router->get('/info','ExampleController@info');
$router->post('/data','ExampleController@data');
$router->post('/register','ExampleController@register');
$router->post('/forgotpassword','ExampleController@forgotpassword');
$router->post('/captcha','ExampleController@captcha');*/




$router->post('/login','AdminController@login');



$router->get('/code/captcha/{tmp}', 'AdminController@captcha');
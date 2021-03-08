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
    // $data = app('cache')->get('aaa');
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



//登录页面后台接口
$router->post('/login','LoginController@login');
$router->post('/info','LoginController@info');
$router->post('/logout','LoginController@logout');
$router->get('/code/captcha/{tmp}', 'LoginController@captcha');



//管理员帐号表格(增删改查)后台接口
$router->post('/addadmin','AdminController@add');
$router->post('/deleteadmin','AdminController@delete');
$router->post('/editadmin','AdminController@edit');
$router->post('/getadmin','AdminController@get');


//题目表格(增删改查)后台接口
$router->post('/addquestion','QuestionController@add');
$router->post('/deletequestion','QuestionController@delete');
$router->post('/editquestion','QuestionController@edit');
$router->post('/getquestion','QuestionController@get');



//答案表格(增删改查)后台接口
$router->post('/addanswer','AnswerController@add');
$router->post('/deleteanswer','AnswerController@delete');
$router->post('/editanswer','AnswerController@edit');
$router->post('/getanswer','AnswerController@get');
$router->post('/answergetquestion','AnswerController@getquestion');
$router->post('/answergetquestiontype','AnswerController@getquestiontype');
$router->post('/answerchangedata','AnswerController@getquestionchange');
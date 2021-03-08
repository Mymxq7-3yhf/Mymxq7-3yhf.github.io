<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Gregwar\Captcha\CaptchaBuilder; 
use Gregwar\Captcha\PhraseBuilder;

use Illuminate\Support\Facades\Redis;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    //内关联表,同一个guid
    public function login(Request $request)
    {

        //拿到数据后,首先验证验证码
        $data = $request->all();
        //如果验证码成功,用帐号和密码一起查询数据库;如果查询到数据,则返回登录表的所有数据给前端,状态码200,如没有,则返回帐号或密码错误,状态码400
        return $data;
    }





    public function logout(Request $request)
    {
        
    }

    public function info(Request $request)
    {
        //接受前端传来的guid,用guid查询info
    }

       // 验证码生成
        public function captcha($tmp)
        {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(3);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        // 可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // dd($phrase);
        // return phpinfo();
        //使用redis存入验证码
        app('redis')->set('captcha',$phrase);
        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
        }



    
}

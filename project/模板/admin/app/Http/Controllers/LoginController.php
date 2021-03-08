<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Gregwar\Captcha\CaptchaBuilder; 
use Gregwar\Captcha\PhraseBuilder;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Redis;


class LoginController extends Controller
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
        $input = $request->all();
        $captcha= app('cache')->get('captcha');

        //md5加密
        $password = md5(md5($input['password']));

        //获取ip
        $ip = $request->ip();
        $sign = strcasecmp($captcha,$input['captcha']);
        if($sign == 0){

            $status = app('db')->table('data_admin')->where(['login_name'=>$input['username'],'status'=>1])->first();
            // return response()->json($status);
            // return $status->login_name;
            $json_status = json_encode($status, JSON_FORCE_OBJECT);
            if( $json_status !='{}'){
                $data = app('db')->table('data_admin')->where(['login_name'=>$input['username'],'password'=>$password])->first();
                
                $json_data = json_encode($data, JSON_FORCE_OBJECT);

                 
                if($json_data != 'null'){
                    app('db')->table('data_admin')->where(['login_name'=>$input['username']])->update(['ip'=> $ip]);
                    return [
                        'code'=> 200,
                        'message'=>"登录成功",
                        'data'=>$data,
                        
                    ];
                }else{
                    return [
                        'code'=>400,
                        'message'=>"帐号或密码错误",
                    ];
                }
            }else{
                return [
                    'code'=>400,
                    'message'=>"该帐号已经冻结或不存在",
                ];
            }
        }
        //如果验证码成功,用帐号和密码一起查询数据库;如果查询到数据,则返回登录表的所有数据给前端,状态码200,如没有,则返回帐号或密码错误,状态码400
    }


    

    public function logout(Request $request)
    {
        $input = $request->all();

        //php生成当前时间
        $showtime=date("Y-m-d H:i:s");
        
        app('db')->table('data_admin')->where(['guid'=>$input['guid']])->update(['lasttime'=> $showtime]);
        
        return [
            'code' => 200,
            'message'=> "成功退出账户",
        ];
        return response()->json($data);
    }

    public function info(Request $request)
    {
        //接受前端传来的guid,用guid查询info
        $input = $request->all();
        $data = app('db')->table('data_admin_info')->where(['guid'=>$input['guid']])->first();
        return [
            'code' => 200,
            'data' =>$data,
            
        ];  
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
        // app('redis')->set('captcha',$phrase);
        app('cache')->put('captcha',$phrase);
        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
        }

        //data_问题
        //tpye   1 单选 2 判断   content 内容    状态1是启用2是禁用
        //data_answer答案表
        //
    
}

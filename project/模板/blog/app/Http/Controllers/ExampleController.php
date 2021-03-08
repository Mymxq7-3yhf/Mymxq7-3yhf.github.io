<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Gregwar\Captcha\CaptchaBuilder; 
use Gregwar\Captcha\PhraseBuilder;

use Illuminate\Support\Facades\Redis;


class ExampleController extends Controller
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
    public function login(Request $request)
    {
        $input = $request->all();
        
        $captcha= app('redis')->get('captcha');
        $sign =false;
        if($captcha == $input['captcha']){
            $sign = true;
        }
        if($input['username'] == 'admin' && $input['password'] == 111111)
        {
            if($sign != true)
            {
                if($captcha != $input['captcha'] )
                {
                    return [
                        'code' => 502,
                        'state' => '验证码错误',
                    ];
                }
                
            }
            app('db')->table('admin')->where(['login_name'=>'余泓锋'])->update(['guid'=> 1]);
            app('db')->table('admin')->where(['login_name'=>'余泓锋'])->update(['captcha'=> $input['captcha']]);
            $data = app('db')->table('admin')->get()->first();
            return [
                'code' => 200,
                'data' => $data,
            ];

        }


        $data = app('db')->table('users')->where(['login_name'=>$input['username']])->get();
        foreach($data as $data);  //拿的是整个数据库,就需要遍历一次,遍历以后为空???? 遍历成为数组
        $status = app('db')->table('users')->where(['login_name'=>$input['username']])->where(['status'=>1])->get();
        $json_status = json_encode($status, JSON_FORCE_OBJECT);
        if($json_status != '{}'){
            if($data!='' && $sign == true)
            {
                if($input['password'] == $data->password  )
                {
                    app('db')->table('users')->where(['id'=>$data->id])->update(['captcha'=> $input['captcha']]);
                    app('db')->table('users')->where(['id'=>$data->id])->update(['guid'=> 1]);
                    return [
                        'code' => 200,
                        'data' => $data,
                    ];

                }else{
                    return [
                        'code' => 501,
                        'state' => '密码错误 !',
                    ];    
                }  
            } 
            if($data!='' && $sign != true)
            {
                if($input['password'] == $data->password  )
                {
                    return [
                        'code' => 502,
                        'state' => '验证码错误',
                    ];
                }else{
                    return [
                        'code' => 503,
                        'state' => '验证码和密码错误',
                    ];
                }
                
            }
        }else{
            return [
                'code'=>401,
                'state'=>'该用户已经冻结',
            ];
        };
        

        return response()->json($data);

    }

    public function register(Request $request)
    {
        $input = $request->all();
        $name = app('db')->table('users')->where(['login_name'=>$input['username']])->get();
        $json_name = json_encode($name, JSON_FORCE_OBJECT);
        if($input['username']!='' && $input['password_one'] != '')
	    {
            if($json_name == '{}'){
                app('db')->table('users')->insert([
                    'login_name'=> $input['username'],
                    'password'=> $input['password_one'],
                    'avatar'=> 'https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=541289240,661364349&fm=26&gp=0.jpg',
                    'status'=> 1,
                    'guid'=> 0,
                    ]);
                $data = app('db')->table('users')->where(['login_name'=>$input['username']])->get();
                return [
                    'code' => 202,
                    'data' =>$data
                ];
            }else{
                return [
                    'code' => 504,
                ];
            }
                
	    }
    }

    public function forgotpassword(Request $request)
    {
        $input = $request->all();
        
        $name = app('db')->table('users')->where(['login_name'=>$input['username']])->get();
        $json_name = json_encode($name, JSON_FORCE_OBJECT);

        if($input['username']!='' && $input['password_old'] != '' && $input['password_new'] != '')
	    {
            if($json_name != '{}'){
                $status = app('db')->table('users')->where(['login_name'=>$input['username']])->where(['status'=>1])->get();
                $json_status = json_encode($status, JSON_FORCE_OBJECT);
                if($json_status != '{}'){
                    $password = app('db')->table('users')->where(['password' => $input['password_old']])->get();
                    $json_password = json_encode($password, JSON_FORCE_OBJECT);
                        if($json_password !='{}'){
                            app('db')->table('users')->where(['login_name'=>$input['username']])->update(['password'=> $input['password_new']]);
                            $data = app('db')->table('users')->where(['login_name'=>$input['username']])->get();
                            return [
                                'code' => 201,
                                'data' =>$data
                            ];
                        }else{
                            return [
                                'code' => 501,
                                'state' => '密码错误'
                            ];
                        }    
                    }else{
                        return [
                            'code'=>401,
                            'state'=>'该用户已经冻结',
                        ];
                    }
            }else{
                return [
                    'code' => 402,
                    'state' => '无该用户'
                ];
            }
        }
    }


    public function logout(Request $request)
    {
        app('db')->table('admin')->where(['login_name'=>'余泓锋'])->update(['guid'=> 0]);
        app('db')->table('users')->update(['guid'=> 0]);
        return [
            'code' => 200,
        ];
        return response()->json($data);
    }


    public function info(Request $request)
    {
        $user = app('db')->table('users')->where(['guid'=>1])->get();
        $admin = app('db')->table('admin')->where(['guid'=>1])->get();

        $json_user = json_encode($user, JSON_FORCE_OBJECT); //转化成JSON字符串

        $json_admin = json_encode($admin, JSON_FORCE_OBJECT);
 

        if($json_user != '{}'){   //判断JSON字符串是否只是{}
            $value = app('db')->table('users')->where(['guid'=>1])->get()->first();//first你是要哪一条呢?(要加get())
            $data = ['code' => 200,'data' => $value];
            return response()->json($data);
        }
        if($json_admin !='{}'){
            $value = app('db')->table('admin')->get()->first();   //哪怕只有一条也要添加 
            $data = ['code' => 200,'data' => $value];
            return response()->json($data);
        }
    }

    public function data()
    {
        $value = app('db')->table('users')->get();
        $data = ['code' => 200,'data' => $value];
        return response()->json($data);

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

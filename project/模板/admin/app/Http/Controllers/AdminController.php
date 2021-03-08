<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Gregwar\Captcha\CaptchaBuilder; 
use Gregwar\Captcha\PhraseBuilder;

use Illuminate\Support\Facades\Redis;


class AdminController extends Controller
{
    

    

    
    //增
    public function add(Request $request)
    {
        $input = $request->all();
        info($input);
        //验证是否存在相同用户名的管理员账户
        $name = app('db')->table('data_admin')->where(['login_name'=>$input['login_name']])->get();
        
        $json_name = json_encode($name, JSON_FORCE_OBJECT);
        
        if($input['login_name']!='' && $input['password'] != '')
	    {
            
            if($json_name == '{}'){
                
                //生成guid
                $guid = Uuid::uuid1();
                //32位字符串方法
                $str = $guid->getHex();
                //php生成当前时间
                $showtime=date("Y-m-d H:i:s");
                //md5加密
                $password = md5(md5($input['password']));
                app('db')->table('data_admin')->insert([
                    'guid' =>$str,
                    'login_name'=> $input['login_name'],
                    'password'=> $password,
                    'status'=> 1,
                    'addtime' =>$showtime,
                    ]);
                app('db')->table('data_admin_info')->insert([
                    'guid' =>$str,
                    'nickname'=> $input['nickname'],
                    'rolename'=> '管理员',
                    'img'=> 'https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=541289240,661364349&fm=26&gp=0.jpg',
                    ]);    
                
                return [
                    
                    'code' => 200,
                    'message'=> "增加成功",
                ];
            }else{
                
                return [
                    'code' => 400,
                    'message'=> "存在相同用户",
                ];
            }
                
	    }
    }
    //删
    public function delete(Request $request)
    {
        $input = $request->all();
        app('db')->table('data_admin')->where(['guid'=>$input['guid']])->update(['status'=> 0]);
        return [
            'code'=>200,
            'message'=> "删除成功",
        ];
    }

    //改
    public function edit(Request $request)
    {
        $input = $request->all();
        info($input['nickname']);
        app('db')->table('data_admin')->where(['guid'=>$input['guid']])->update(['status'=>$input['status']]);
        app('db')->table('data_admin_info')->where(['guid'=>$input['guid']])->update([
                'nickname'=>$input['nickname'],
                'rolename'=>$input['rolename'],
            ]);
        return [
            'code'=>200,
            'message'=> "修改成功",
        ];
    }


    //查
    public function get(Request $request)
    {
        // info($request);
        $many = $request['maxPage'];
        $skip = ($request['currentPage']-1) * $many;
        
        $data = app('db')->table('data_admin')->leftJoin('data_admin_info', 'data_admin.guid', '=', 'data_admin_info.guid')
        ->skip($skip)
        ->take($many)
        ->get();

        $count = app('db')->table('data_admin')->count();
        return [
            'code' => 200,
            'data' =>$data,
            'count' =>$count
        ];
    }



    

}
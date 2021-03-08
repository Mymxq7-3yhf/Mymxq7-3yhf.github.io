<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Gregwar\Captcha\CaptchaBuilder; 
use Gregwar\Captcha\PhraseBuilder;

use Illuminate\Support\Facades\Redis;


class QuestionController extends Controller
{
    //增
    public function add(Request $request)
    {
        $input = $request->all();
        info($input);
        //验证是否存在相同用户名的管理员账户
        $name = app('db')->table('data_question')->where(['content'=>$input['content']])->first();
        
        $json_name = json_encode($name, JSON_FORCE_OBJECT);
            if($json_name =='null'){
                info(1);
                //生成guid
                $guid = Uuid::uuid1();
                //32位字符串方法
                $str = $guid->getHex();
                //php生成当前时间
                $showtime=date("Y-m-d H:i:s");
                //当前管理员guid
                $guid_admin = $input['guid'];
                //判断题目类型(看看返回的是数字还是文字)
                info($input['type']);
                //文字
                // if($input['type'] == '单选'){
                //     $type = 1;
                // }
                // if($input['type'] == '判断'){
                //     $type = 2;
                // }
                // //数字
                $type = $input['type'];
                
                $dadta=app('db')->table('data_question')->insert([
                    'guid' =>$str,
                    'type'=>  $type,
                    'content' =>$input['content'],
                    'status'=> 1,
                    'add_user'=> $guid_admin,
                    'addtime' =>$showtime,
                    ]);
                    info($dadta);
                return [
                    'code' => 200,
                    'message'=> "增加成功",
                ];
            }else{
                
                return [
                    'code' => 400,
                    'message'=> "该题目已存在",
                ];
            }
                
    }
    //删
    public function delete(Request $request)
    {
        $input = $request->all();
        app('db')->table('data_question')->where(['guid'=>$input['guid']])->update(['status'=> 2]);
        return [
            'code'=>200,
            'message'=> "删除成功",
        ];
    }

    //改
    public function edit(Request $request)
    {
        $input = $request->all();
        if($input['type']=="单选题"){
            app('db')->table('data_question')->where(['guid'=>$input['guid']])->update(['type'=> 1]);
        }
        if($input['type']=="判断题"){
            app('db')->table('data_question')->where(['guid'=>$input['guid']])->update(['type'=> 2]);
        }
        app('db')->table('data_question')->where(['guid'=>$input['guid']])->update(['status'=>$input['status']]);
        return [
            'code'=>200,
            'message'=> "修改成功",
        ];
    }


    //查
    public function get(Request $request)
    {
        $many = $request['maxPage'];
        $skip = ($request['currentPage']-1) * $many;
        
        $data = app('db')->table('data_question')
                ->skip($skip)
                ->take($many)
                ->get();
        $count = app('db')->table('data_question')->count();
        return [
            'code' => 200,
            'data' =>$data,
            'count' =>$count
        ];
    }

}
<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Gregwar\Captcha\CaptchaBuilder; 
use Gregwar\Captcha\PhraseBuilder;

use Illuminate\Support\Facades\Redis;


class AnswerController extends Controller
{
    //增
    public function add(Request $request)
    {
        
        $input = $request->all();
        // info($input);
        //拿到的是字符串,(要转换成json对象)
        $data=$input['data'];  
        //转化成json对象
        $data = json_decode($data);  //转换以后要接收
        // info($data->content);

        //验证是否存在相同的答案
        $one = app('db')->table('data_answer')->where(['content'=>$data->content])->first();
        $json_one = json_encode($one, JSON_FORCE_OBJECT);
        //(额外答案)
        if($data->excessItem != null){
            info(777);
            $result = count ( $data->excessItem);
            $excess = $data->excessItem;
            for($i=0;$i<$result;$i++){
                $two = app('db')->table('data_answer')->where(['content'=>$excess[$i]->content])->first();
                $json_two = json_encode($two, JSON_FORCE_OBJECT);
            }
        }
        //一定要添加的答案
        if($json_one =='null' || $json_two =='null'){
            if($json_one =='null'){
                //当前答案对应题目guid
                $guid = $input['guid'];
                //判断答案是否正确
                $isright = $data->radio;
                app('db')->table('data_answer')->insert([
                    'question_guid' =>$guid,
                    'content' =>$data->content,  
                    'isright'=>  $isright,
                    'status'=> 1,
                    ]);
            }
            //额外添加的答案
            if($json_two =='null'){
                info(777);
                for($i=0;$i<$result;$i++){
                //当前答案对应题目guid
                $guid = $input['guid'];
                //判断答案是否正确
                $isright = $excess[$i]->radio;
                app('db')->table('data_answer')->insert([
                    'question_guid' =>$guid,
                    'content' =>$excess[$i]->content,  
                    'isright'=>  $isright,
                    'status'=> 1,
                    ]);
                }
            }  
            return [
                'code' => 200,
                'message'=> "增加成功",
            ];
        }
       
        else{   
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
        // info($input); 
        
        app('db')->table('data_answer')->where(['id'=>$input['id']])->update(['status'=> 2]);
        return $input;
        return [
            'code'=>200,
            'message'=> "删除成功",
        ];
    }

    //改
    public function edit(Request $request)
    {
        $input = $request->all();
        // info($input);
        
        //将前端传来的请求数据,转换成内容对应的guid
        $getguid = app('db')->table('data_question')->where(['content'=>$input['question_guid']])->get();
        $getguid = $getguid[0]->guid;   //取值注意(是数组对象,数组.,对象->)
        // info($getguid);   

        //将前端传来的请求数据,转换成内容对应的isright
        if($input['isright'] == "正确"){
            app('db')->table('data_answer')->where(['id'=>$input['id']])->update(['isright'=>1]);
        }
        if($input['isright'] == "错误"){
            app('db')->table('data_answer')->where(['id'=>$input['id']])->update(['isright'=>2]);
        } 
    
        //修改了题目,将对应题目的guid修改进数据库
        app('db')->table('data_answer')->where(['id'=>$input['id']])->update(['question_guid'=> $getguid]);
        
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
        

        $data = app('db')->table('data_answer')
                // ->where(['status' => 1])
                ->skip($skip)
                ->take($many)
                ->get();

                
        $count = app('db')->table('data_answer')->count();
        return [
            'code' => 200,
            'data' =>$data,
            'count' =>$count
        ];
    }


    //拿题目guid和内容
    public function getquestion(Request $request)
    {
        
        $data = app('db')->table('data_question')->get();
        
        
        return [
            'code' => 200,
            'data' =>$data,
            
        ];
    }
    //用题目guid拿数据
    public function getquestiontype(Request $request)
    {
        $input = $request->all();
        
        $data = app('db')->table('data_question')->where(['guid'=>$input['guid']])->get();
        return [
            'code' => 200,
            'data' =>$data,
        ];
    }

    //对应题目guid拿题目内容
    public function getquestionchange()
    {
        $data = app('db')->table('data_question')->get();
        $count = app('db')->table('data_question')->count();
        return [
            'code' => 200,
            'data' =>$data,
            'count' =>$count
        ];
    }


}
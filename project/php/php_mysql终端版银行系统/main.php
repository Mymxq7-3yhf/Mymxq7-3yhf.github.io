<?php 
    namespace main;
    require_once 'link.php';
    
    
    $find = false;
    $sign = false;
    do{   
        echo "请输入管理员账号:";
        $name_signsql = fgets(STDIN);
        $name_signsql = str_replace(PHP_EOL, '', $name_signsql);   
        try {
            global $conn;
            $conn->query("set names 'utf8'");

            $sql = "SELECT id,username,passWordsql FROM data_admin  ";       //获取数据库数据
            $querysql = $conn->query($sql);
            foreach($querysql as $rs)       //遍历所取得的数据
            {      
                if($name_signsql == $rs['username']){
                        $find = true;
                        $id_signsql = $rs['id'];        //获取相应的id
                        $passWordsql_signsql = $rs['passWordsql'];//获取相应的密码
                } 
            }
            do{
                echo "请输入管理员密码:";
                    $pw_signsql = fgets(STDIN);
                    $pw_signsql = str_replace(PHP_EOL, '', $pw_signsql); 
                if( $pw_signsql == $passWordsql_signsql ){
                    require("index.php");
                    $sign = true;
                }else{
                    echo "密码错误,请重新输入!\n";
                }
            }while(!$sign);
            
                
            
            if($name_signsql != $rs['username']){
                echo "查无用户,请重新输入!\n";
            }    
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }             
    }while(!$find);
  


    
    
    


?>
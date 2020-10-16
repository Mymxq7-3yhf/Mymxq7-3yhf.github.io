<?php 
    namespace option;

    
    trait Operation
    {
       
        //开户
        public function open(){
            $sign = true;
            echo "请输入您的姓名:";
            $name = fgets(STDIN);
            $name = str_replace(PHP_EOL, '', $name);

            echo "请输入您的身份证号:";
            $id = fgets(STDIN);
            $id = str_replace(PHP_EOL, '', $id);
            
            echo "请输入您的手机号:";
            $phone = fgets(STDIN);
            $phone = str_replace(PHP_EOL, '', $phone);

            while($sign){
                echo "请输入您的密码:";
                $pw_one = fgets(STDIN);
                $pw_one = str_replace(PHP_EOL, '', $pw_one);

                echo "请确认您的密码:";
                $pw_two = fgets(STDIN);
                $pw_two = str_replace(PHP_EOL, '', $pw_two);

                if($pw_one != $pw_two){
                    echo "两次密码不一致,请重新输入!";
                    echo PHP_EOL;
                }else {
                    $cardID = rand(1000000, 9999999);
                    $money = 37;
                    $this->Person[$this->index]["姓名"] = $name;
                    $this->Person[$this->index]["身份证号"] = $id;
                    $this->Person[$this->index]["手机号"] = $phone;
                    $this->Person[$this->index]["密码"] = $pw_one;
                    $this->Person[$this->index]["卡号"] = $cardID;
                    $this->Person[$this->index]["余额"] = $money;
                    $this->Person[$this->index]["状态"] = true;

                    print_r($this->Person);
                    echo "恭喜您" . $name . "注册成功，您的卡号是" . $cardID . ",卡内余额".$money."元\n";
                    $this->index++;
                    $sign = false; 
                    
                }
            }

        }
        //查询
        public function query ()
        {
            $arrlength = count($this->Person);
            $query = false;
            $find = false;
            $frequency = 3;

                do{
                    echo "请输入您的卡号";
                    $cardID = fgets(STDIN);
                    $cardID = str_replace(PHP_EOL, '', $cardID);
    
                    for ($i = 0; $i < $arrlength; $i++) {
                        if ($this->Person[$i]["卡号"] == $cardID) {
                            $index = $i;
                            $find = true;
                            $state = $this->Person[$i]["状态"];
                        }
                    }
                    if(!$find){
                        echo "查无此号,请重新输入!";
                        echo PHP_EOL;
                        
                    }else{
                        if($state){
                            echo "请输入您的密码";
                            $pw_ture = fgets(STDIN);
                            $pw_ture = str_replace(PHP_EOL, '', $pw_ture);
    
                            for ($i = 0; $i < $arrlength; $i++) {
                                if ($this->Person[$i]["卡号"] == $cardID and $this->Person[$i]["密码"] == $pw_ture) {
                                    echo "卡内余额为" . $this->Person[$i]["余额"] . "元\n";
                                    $query = true;
                                }
                            }
                            if (!$query) {
                                $frequency--;
                                echo "密码错误，您还剩下" . $frequency . "次机会！\n";
                            }
                        }else{
                            echo "该卡已经锁定!\n";
                            
                        }
                    }
                        
                }while(!$find and $query == false and $frequency != 0); 
        }
        //存钱
        public function save(){
            $arrlength = count($this->Person);
            $find = false;
            $find = false;
            do{
                echo "请输入您的卡号:";
                $cardID = fgets(STDIN);
                $cardID = str_replace(PHP_EOL, '', $cardID);
                for ($i = 0; $i < $arrlength; $i++) {
                    if ($this->Person[$i]["卡号"] == $cardID) {
                        $index = $i;
                        $name = $this->Person[$i]["姓名"];
                        $state = $this->Person[$i]["状态"];
                        $find = true;
                    }
                }
                if(!$find){
                    echo "查无此号,请重新输入!";
                    echo PHP_EOL;
                    
                }else{
                    if($state){
                        if ($find) {
                            echo "您输入的账户名为:".$name;
                            echo PHP_EOL;
                            echo "确认存款请按1,任意键返回上一层!";
                            $next = fgets(STDIN);
                            $next = str_replace(PHP_EOL, '', $next);
                        } else {
                            echo "无此卡号";
                        }
                        if($next == 1){
                            echo "请输入您要存款的金额";
                            $money = fgets(STDIN);
                            $money = str_replace(PHP_EOL, '', $money);
                            $this->Person[$index]["余额"] +=  $money;
                            echo "成功存入了".$money."元\n";
                        }
                    }else{
                        echo "该卡已经锁定!\n";
                    }
                }
            }while(!$find);
            
        }

        //取钱
        public function  get_money()
        {

            $arrlength = count($this->Person);
            $query = false;
            $find = false;
            $frequency = 2;

                do{
                    echo "请输入您的卡号";
                    $cardID = fgets(STDIN);
                    $cardID = str_replace(PHP_EOL, '', $cardID);
                    for ($i = 0; $i < $arrlength; $i++) {
                        if ($this->Person[$i]["卡号"] == $cardID) {
                            $index = $i;
                            $name = $this->Person[$i]["姓名"];
                            $state = $this->Person[$i]["状态"];
                            $find = true;
                        }
                    }
                    if(!$find){
                        echo "查无此号,请重新输入!";
                        echo PHP_EOL;
                    }else{
                        if($state){ 
                            echo "请输入您的密码";
                            $pw_ture = fgets(STDIN);
                            $pw_ture = str_replace(PHP_EOL, '', $pw_ture);
                            for ($i = 0; $i < $arrlength; $i++) {
                                if ($this->Person[$i]["卡号"] == $cardID and $this->Person[$i]["密码"] == $pw_ture) {
                                echo "您输入的账号名为" . $this->Person[$i]["姓名"] . "\n";
                                echo "确认取钱请按1，任意键返回上一级！";
                                $next = fgets(STDIN);
                                $next = str_replace(PHP_EOL, '',  $next);
                                $query = true;
                                $index = $i;
                                }
                            }
                            if (!$query) {
                                echo "密码错误，您还剩下" . $frequency . "次机会！\n";
                                $frequency--;
                            }
                            if ($next == 1) {
                                echo "请输入您要取款的金额";
                                $money = fgets(STDIN);
                                $money = str_replace(PHP_EOL, '',  $money);
                                if ($money > $this->Person[$index]["余额"]) {
                                    echo "余额不足\n";
                                } else {
                                    $this->Person[$index]["余额"] -= $money;
                                    echo "成功取出了" . $money . "元\n";
                                }
                            }
                        }else{
                            echo "该卡已经锁定!\n";
                        }
                    }
                }while(!$find and $query == false and $frequency != 0);   

        }
    
        //转账
        public function trans_money()
        {
    
            $arrlength = count($this->Person);
            $find_c = false;
            $find_s = false;
            $next = 0;

            do{
                echo "请输入您的卡号";
                $c_cardID = fgets(STDIN);
                $c_cardID = str_replace(PHP_EOL, '',  $c_cardID);
                for ($i = 0; $i < $arrlength; $i++) {
                    if ($this->Person[$i]["卡号"] == $c_cardID) {
                        $c_index = $i;
                        $c_name = $this->Person[$i]["姓名"];
                        $state_c = $this->Person[$i]["状态"];
                        $find_c = true;
                        $next = 2;
                    }
                }
                
                if ($find_c) {
                    echo "您的账户名为" . $c_name;
                    echo PHP_EOL;
                    if(!$state_c){
                        echo "该卡已经锁定!\n";  
                    }
                } else {
                    echo "无此卡号,请重新输入\n";
                }
            }while(!$find_c);
            
            if($state_c){
                do{
                    if ($next == 2) {
                        echo "请输入对方的卡号";
                        $s_cardID = fgets(STDIN);
                        $s_cardID = str_replace(PHP_EOL, '',  $s_cardID);
                        for ($y = 0; $y < $arrlength; $y++) {
                            if ($this->Person[$y]["卡号"] == $s_cardID) {
                                $s_index = $y;
                                $s_name = $this->Person[$y]["姓名"];
                                $state_s = $this->Person[$i]["状态"];
                                $find_s = true;
                                $next = 3;
                            }
                        }
                        if ($find_s) {
                            echo "对方的账户名为" . $s_name;
                            echo PHP_EOL;
                            if(!$state_s){
                                echo "该卡已经锁定!\n";  
                            }
                        } else {
                            echo "无此卡号,请重新输入\n";
                        }
                    }
                }while(!$find_s);
            }
            
            
    
            if ($next == 3) {
                echo "确认转账请按1，任意键返回上一级！\n";
                $next = fgets(STDIN);
                $next = str_replace(PHP_EOL, '',  $next);
                if ($next == 1) {
                    $trans_sign = false;
                    do{
                        echo "请输入您要转账的金额";
                        $money = fgets(STDIN);
                        $money = str_replace(PHP_EOL, '',  $money);
                        if ($money > $this->Person[$c_index]["余额"]) {
                            echo "余额不足\n";
                        } else {
                            $this->Person[$c_index]["余额"] -= $money;
                            $this->Person[$s_index]["余额"] += $money;
                            $trans_sign = true;
                            echo "成功向对方转账了" . $money . "元\n";
                    }
                    }while(!$trans_sign);
                    
                }
            }
        }
        //改密
        public function change_pwd()
        {

            $arrlength = count($this->Person);
            $frequency = 2;
            $find = false;
            do{
                echo "请输入您的卡号";
                $cardID = fgets(STDIN);
                $cardID = str_replace(PHP_EOL, '',  $cardID);
                for ($i = 0; $i < $arrlength; $i++) {
                    if ($this->Person[$i]["卡号"] == $cardID) {
                        $name_old = $this->Person[$i]["姓名"];
                        $id_old = $this->Person[$i]["身份证号"];
                        $phone_old = $this->Person[$i]["手机号"];
                        $state = $this->Person[$i]["状态"];
                        $find = true;
                        $index = $i;
                    }
                }
                if ($find) {
                    echo "您的账户名为" . $name_old;
                    echo PHP_EOL;
                    if(!$state){
                        echo "该卡已经锁定!\n";  
                    }
                } else {
                    echo "无此卡号,请重新输入\n";
                }
            }while(!$find);
            
            if ($find and $state) {
                while ($frequency != 0) {
                    echo "请输入您的姓名";
                    $name_new = fgets(STDIN);
                    $name_new = str_replace(PHP_EOL, '',  $name_new);
                    echo "请输入您的身份证号码";
                    $id_new = fgets(STDIN);
                    $id_new = str_replace(PHP_EOL, '',  $id_new);
                    echo "请输入您的手机号";
                    $phone_new = fgets(STDIN);
                    $phone_new = str_replace(PHP_EOL, '',  $phone_new);
                    if ($name_new == $name_old and $id_new == $id_old and $phone_new == $phone_old) {
                        $ps = true;
                        while ($ps) {
                            echo "请输入您的新密码";
                            $psword_one = fgets(STDIN);
                            $psword_one = str_replace(PHP_EOL, '',  $psword_one);

                            echo "请确认您的新密码";
                            $psword_two = fgets(STDIN);
                            $psword_two = str_replace(PHP_EOL, '',  $psword_two);

                            if ($psword_one != $psword_two) {
                                echo "两次密码不一致，请重新输入！\n";
                            } else {
                                echo "修改成功\n";
                                $this->Person[$index]["密码"] = $psword_one;
                                $ps = false;
                                $frequency = 0;
                            }
                        }
                    } else {
                        echo "核验信息不对请重新输入\n";
                        $frequency--;
                    }
                }
            } 
        }
        //锁卡
        public function lock()
        {

            $arrlength = count($this->Person);
            $frequency = 2;
            $find = false;
            do{
                echo "请输入您的用户名";
                $name = fgets(STDIN);
                $name = str_replace(PHP_EOL, '',  $name);
                for ($i = 0; $i < $arrlength; $i++) {
                    if ($this->Person[$i]["姓名"] == $name) {
                        $cardID_get = $this->Person[$i]["卡号"];
                        $id_get = $this->Person[$i]["身份证号"];
                        $phone_get = $this->Person[$i]["手机号"];
                        echo "您的卡号为：" . $cardID_get . "\n";
                        $find = true;
                        $index = $i;
                    }
                }   
                if ($find) {
                    while ($frequency != 0) {
                        echo "请输入您的身份证号码";
                        $id_sign = fgets(STDIN);
                        $id_sign = str_replace(PHP_EOL, '',  $id_sign);
                        echo "请输入您的手机号";
                        $phone_sign = fgets(STDIN);
                        $phone_sign = str_replace(PHP_EOL, '',  $phone_sign);
                        if ($id_get == $id_sign and $phone_get == $phone_sign) {
                            echo "确认锁定请按1，任意键返回上一级！\n";
                            $next = fgets(STDIN);
                            $next = str_replace(PHP_EOL, '',  $next);
                            if ($next == 1) {
                                $this->Person[$index]["状态"] = false;
                                echo "该卡已锁定!\n";
                            }
                            $frequency = 0;
                            } else {
                                echo "核验信息有误,请重新输入\n";
                                $frequency--;
                            }
                        }
                    } else {
                        echo "无此用户,请重新输入\n";
                    }
                }while(!$find);
            
            }
        //解卡
        public function unlock()
        {

            $arrlength = count($this->Person);
            $frequency = 2;
            $find = false;
            do{
                echo "请输入您的用户名";
                $name = fgets(STDIN);
                $name = str_replace(PHP_EOL, '',  $name);
                for ($i = 0; $i < $arrlength; $i++) {
                    if ($this->Person[$i]["姓名"] == $name) {
                        $cardID_get = $this->Person[$i]["卡号"];
                        $id_get = $this->Person[$i]["身份证号"];
                        $phone_get = $this->Person[$i]["手机号"];
                        
                        echo "您的卡号为：" . $cardID_get . "\n";
                        $find = true;
                        $index = $i;
                    }
                }
                if ($find) {
                    while ($frequency > 0) {
                        echo "请输入您的身份证号码";
                        $id_sign = fgets(STDIN);
                        $id_sign = str_replace(PHP_EOL, '',  $id_sign);
                        echo "请输入您的手机号";
                        $phone_sign = fgets(STDIN);
                        $phone_sign = str_replace(PHP_EOL, '',  $phone_sign);
                        if ($id_sign == $id_get and $phone_sign == $phone_get) {
                            echo "确认解锁请按1，任意键返回上一级！\n";
                            $next = fgets(STDIN);
                            $next = str_replace(PHP_EOL, '',  $next);
                            if ($next == 1) {
                                $this->Person[$index]["状态"] = true;
                            }
                            $frequency = -1;
                        } else {
                            echo "核验信息有误,请重新输入\n";
                            $frequency--;
                        }
                    }
                } else {
                    echo "无此用户,请重新输入\n";
                }
                }while(!$find); 
            }
        //补卡
        public function add()
        {
            $arrlength = count($this->Person);
            $frequency = 2;
            $find = false;
            do{
                echo "请输入您的用户名";
                $name = fgets(STDIN);
                $name = str_replace(PHP_EOL, '',  $name);
                $cardID = rand(1000000, 9999999);
                for ($i = 0; $i < $arrlength; $i++) {
                    if ($this->Person[$i]["姓名"] == $name) {
                        echo "您的原卡号为：" . $this->Person[$i]["卡号"] . "\n";
                        echo "是否补办?(0/1)\n";
                        $sign = fgets(STDIN);
                        $sign = str_replace(PHP_EOL, '',  $sign);
                        if($sign == 1){
                            $this->Person[$i]["卡号"] = $cardID;   
                            echo "补卡成功!您的卡号为：" . $cardID . "\n";
                        }
                        $find = true;
                        $index = $i;
                    }
                }
            
            }while(!$find);
        }   
    }

    // class option{
    //     use Operation;
    // }    

?>
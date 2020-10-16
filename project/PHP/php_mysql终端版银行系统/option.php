<?php 
    namespace option;
    require_once 'link.php';
    
    trait Operation
    {
        
        //开户
        public function open(){
            //标记
            $sign = true;
            $name_sign = false;
            $id_sign = false;
            $phone_sign = false;
            $pw_one_sign = false;
            $pw_two_sign = false;


            do{
                echo "请输入您的姓名:";
                $name = fgets(STDIN);
                $name = str_replace(PHP_EOL, '', $name);
                $result = preg_match("/^[A-Za-z0-9]+$/",$name); //判断是否只含有中文,如果是返回0,如果不是返回1
                if($result == 1)//如验证含有中文、数字、英文大小写的字符
                { 
                    echo "该银行系统只支持中文,请输入中文,蟹蟹\n";  //包含中文和特殊字符
                }else {
                    $name_sign = true;  //不包含中文和特殊字符
                }
            }while(!$name_sign);   

            do{
                echo "请输入您的身份证号:";
                $id = fgets(STDIN);
                $id = str_replace(PHP_EOL, '', $id);
                
                try {
                    $index_id = 0;
                    global $conn;
                    $conn->query("set names 'utf8'");

                    $sql = "SELECT idCard FROM data_card  ";
                    $query_id = $conn->query($sql);
                    
                    foreach($query_id as $rs)
	                {      

		                if($id == $rs['idCard']){
                            echo "已存在身份信息,请进行别的操作\n";
                            return $id_sign = false;
                        }
                        if($id != $rs['idCard'] && $index_id == 0){
                            $result = 0;
                            if (preg_match("/^\d{17}\d|X$/", $id)) {
                                //定义身份证号前17位的校验权
                                $arr_right = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
                                //前17位运算后的正确校验码
                                $arr_valid = [1, 0, "X", 9, 8, 7, 6, 5, 4, 3, 2];
                                $sum = 0;
                                for ($i = 0; $i < count($arr_right); $i++) {
                                    $sum += $id[$i] * $arr_right[$i];
                                }
                                $check_code = $sum % 11;
                                if ($id[17] == $arr_valid[$check_code]) {
                                    $result = 1;
                                } else {
                                     $result = 0;
                                }
                            } else {
                                    $result = 0;
                            }
            
                            if($result == 0)//如验证含有中文、数字、英文大小写的字符
                            { 
                                echo "身份证号不正确,请再次输入,蟹蟹\n";    //身份证号不是18位
                            }else {
                                $id_sign = true;  //身份证号是18位
                            }
                        }
                        $index_id++;
                    }
                }
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }


               
            }while(!$id_sign); 
            
            
            
            do{
                echo "请输入您的手机号:";
                $phone = fgets(STDIN);  
                $phone = str_replace(PHP_EOL, '', $phone);
                $result = preg_match("/^1[34578]\d{9}$/",$phone); //判断输入的手机号是否为11位,如果是返回1,不是返回0
                // "^"符号表示必须是1开头; "[ ]"的意思是第二个数字必须是中括号中一个数字;
                // 而 \d 则表示0-9任意数字,后跟{9}表示长度是9个数字; 
                //后面的$表示结尾; 开始和结尾的 / 是正则表达式必须放在这个中间, 有的后面可能还跟模式.

                try {
                    global $conn;
                    $conn->query("set names 'utf8'");

                    $sql = "SELECT phonesql FROM data_card  ";
                    $query_id = $conn->query($sql);
                    
                    foreach($query_id as $rs)
	                {      
                        if($phone == $rs['phonesql']){
                            echo "手机号重复,返回主菜单\n";
                            return 0;
                        }
                    }
                    if($result == 0)//如验证含有中文、数字、英文大小写的字符
                    {                               
                        echo "手机号不正确,请再次输入,蟹蟹\n";  //手机号不是11位
                    }else {
                        $phone_sign = true;  //手机号是11位
                    }
                }
                
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }while(!$phone_sign);



            
            while($sign){
                do{
                    echo "请输入您的密码:";
                    $pw_one = fgets(STDIN);
                    $pw_one = str_replace(PHP_EOL, '', $pw_one);
                    $result = preg_match("/^[0-9a-zA-Z]{3,27}$/",$pw_one);  //判断密码是否是数字跟字母的组合(无特殊字符和中文),并且是3-27位
                    if($result == 0)//返回0,密码要求不符合
                    {
                        echo "密码非法,请重新输入,蟹蟹\n";
                    }else {         //返回1,密码符合要求
                        $pw_one_sign = true;  
                    }
                }while(!$pw_one_sign);
                
                
                echo "请确认您的密码:";
                $pw_two = fgets(STDIN);
                $pw_two = str_replace(PHP_EOL, '', $pw_two);
                    
    
                if($pw_one != $pw_two){
                    echo "两次密码不一致,请重新输入!";
                    echo PHP_EOL;
                }else {
                    $cardID = rand(1000000, 9999999);
                    $money = 37;
                    $state = 1;
                    try {
                        global $conn;
                        $conn->query("set names 'utf8'");
                        $sql = "INSERT INTO data_card(cardID,moneysql,statesql,namesql,passWordsql,idCard,phonesql,addTime)
                        VALUES ('$cardID','$money','$state','$name','$pw_one','$id','$phone',now())";
                        $conn->exec($sql);
                        echo "新记录插入成功\n";
                    }
                    catch(PDOException $e)
                    {
                        echo $sql . "\n" . $e->getMessage();
                    }
                    $sign = false; 
                }  
            }

        }
        //查询
        public function query ()
        {
            //标记
            $query_zero = false;
            $find = false;
            $frequency = 3;

            do{   
                echo "请输入您的卡号:";
                $cardID = fgets(STDIN);
                $cardID = str_replace(PHP_EOL, '', $cardID);     
                try {
                    $index_cardID = 0;
                    global $conn;
                    $conn->query("set names 'utf8'");
    
                    $sql = "SELECT id,cardID,statesql,passWordsql,moneysql FROM data_card  ";       //获取数据库数据
                    $querysql = $conn->query($sql);
                    foreach($querysql as $rs)       //遍历所取得的数据
	                {      
		                if($cardID == $rs['cardID']){
                            if($rs['statesql'] == 1) {
                                $find = true;
                                $id_signsql = $rs['id'];
                                $pw_signsql = $rs['passWordsql'];
                                $money_signsql = $rs['moneysql'];
                            }else{
                                echo "该卡已经锁定!\n";
                                return 0;
                            }
                            $index_cardID++;
                        } 
                    }
                    while($find and $query_zero !=true and $frequency !=0){     
                        echo "请输入您的密码:";
                        $pw_ture = fgets(STDIN);
                        $pw_ture = str_replace(PHP_EOL, '', $pw_ture);
                        
                        if ($pw_ture == $pw_signsql ) {
                            echo "卡内余额为" . $money_signsql . "元\n";
                            $query_zero = true;
                        }
                        if(!$query_zero) {
                            $frequency--;
                            echo "密码错误，您还剩下" . $frequency . "次机会！\n";
                        }
                    }
                    if($frequency == 0 ){
                        $sql = "UPDATE  data_card SET statesql = 0 WHERE id='$id_signsql'"; 
                        $conn->exec($sql);      //写进数据库
                        echo "该卡已锁定,密码都记不清楚?吃饭没见你忘记\n";
                    }
                    if($cardID != $rs['cardID'] && $index_cardID == 0){
                        echo "查无此号,请重新输入!\n";
                    }    
                }
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }             
            }while(!$find);                      
        }
        //存钱
        public function save(){
            //标记
            $find = false;
            do{   
                echo "请输入您的卡号:";
                $cardID = fgets(STDIN);
                $cardID = str_replace(PHP_EOL, '', $cardID);     
                try {
                    $index_cardID = 0;
                    global $conn;
                    $conn->query("set names 'utf8'");
    
                    $sql = "SELECT id,cardID,statesql,namesql,passWordsql,moneysql FROM data_card  ";       //获取数据库数据
                    $querysql = $conn->query($sql);
                    foreach($querysql as $rs)       //遍历所取得的数据
	                {      
		                if($cardID == $rs['cardID']){
                            if($rs['statesql'] == 1) {
                                $find = true;
                                $id_signsql = $rs['id'];        //获取相应的id
                                $name_signsql = $rs['namesql']; //获取相应的名字
                                $money_signsql = $rs['moneysql'];//获取相应的钱
                            }else{
                                echo "该卡已经锁定!\n";
                                return 0;
                            }
                            $index_cardID++;
                        } 
                    }
                    
                    do{     
                        echo "您的用户名为:".$name_signsql;
                        echo PHP_EOL;
                        echo "确认存款请按1,任意键返回上一层!";
                        $next = fgets(STDIN);
                        $next = str_replace(PHP_EOL, '', $next);
                        
                        if ($next == 1) {
                            echo "请输入您要存款的金额:";
                            $money = fgets(STDIN);
                            $money = str_replace(PHP_EOL, '', $money); 
                            $money_signsql = $money_signsql + $money;
                            $sql = "UPDATE  data_card SET moneysql = '$money_signsql'  WHERE id='$id_signsql'"; 
                            $conn->exec($sql);
                            echo "成功存入了".$money."元\n";
                        }
                    }while($find and $next == 1);
                    if($cardID != $rs['cardID'] && $index_cardID == 0){
                        echo "查无此号,请重新输入!\n";
                    }    
                }
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }             
            }while(!$find);
        }

        //取钱
        public function  get_money()
        {
            //标记
            $arrlength = count($this->Person);
            $query_zero = false;
            $find = false;
            $frequency = 3;
            $find = false;

            do{   
                echo "请输入您的卡号:";
                $cardID = fgets(STDIN);
                $cardID = str_replace(PHP_EOL, '', $cardID);     
                try {
                    $index_cardID = 0;
                    global $conn;
                    $conn->query("set names 'utf8'");
    
                    $sql = "SELECT id,cardID,statesql,namesql,passWordsql,moneysql FROM data_card  ";       //获取数据库数据
                    $querysql = $conn->query($sql);
                    foreach($querysql as $rs)       //遍历所取得的数据
	                {      
		                if($cardID == $rs['cardID']){
                            if($rs['statesql'] == 1) {
                                $find = true;
                                $id_signsql = $rs['id'];        //获取相应的id
                                $name_signsql = $rs['namesql']; //获取相应的名字
                                $money_signsql = $rs['moneysql'];//获取相应的钱
                                $pw_signsql =  $rs['passWordsql'];//获取相应的密码
                            }else{
                                echo "该卡已经锁定!\n";
                                return 0;
                            }
                            $index_cardID++;
                        } 
                    }
                    
                    while($find and $query_zero !=true and $frequency !=0){     
                        echo "请输入您的密码:";
                        $pw_ture = fgets(STDIN);
                        $pw_ture = str_replace(PHP_EOL, '', $pw_ture);
                        
                        if ($pw_ture == $pw_signsql) {
                            echo "卡内余额为" . $money_signsql . "元\n";
                            do{     
                                echo "您的用户名为:".$name_signsql;
                                echo PHP_EOL;
                                echo "确认取款请按1,任意键返回上一层!";
                                $next = fgets(STDIN);
                                $next = str_replace(PHP_EOL, '', $next);
                                
                                if ($next == 1) {
                                    echo "请输入您要取款的金额:";
                                    $money = fgets(STDIN);
                                    $money = str_replace(PHP_EOL, '', $money); 
                                    if($money < $money_signsql){
                                        $money_signsql = $money_signsql - $money;
                                        $sql = "UPDATE  data_card SET moneysql = '$money_signsql'  WHERE id='$id_signsql'"; 
                                        $conn->exec($sql);
                                        echo "成功取出了".$money."元\n";
                                    }else{
                                        echo "余额不足,请重新输入\n";
                                    }
                                    
                                }
                            }while($find and $next == 1);
                            $query_zero = true;
                        }
                        if(!$query_zero) {
                            $frequency--;
                            echo "密码错误，您还剩下" . $frequency . "次机会！\n";
                        }
                    }
                    if($frequency == 0 ){
                        $sql = "UPDATE  data_card SET statesql = 0 WHERE id='$id_signsql'"; 
                        $conn->exec($sql);      //写进数据库
                        echo "该卡已锁定,密码都记不清楚?吃饭没见你忘记\n";
                    }
                    if($cardID != $rs['cardID'] && $index_cardID == 0){
                        echo "查无此号,请重新输入!\n";
                    }    
                }
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }             
            }while(!$find);
        }
    
        //转账
        public function trans_money()
        {
            $find_c = false;
            $find_s = false;
            $next = 0;

            do{   
                echo "请输入您的卡号:";
                $cardID_c = fgets(STDIN);
                $cardID_c = str_replace(PHP_EOL, '', $cardID_c);     
                try {
                    $index_cardID = 0;
                    global $conn;
                    $conn->query("set names 'utf8'");
    
                    $sql = "SELECT id,cardID,statesql,namesql,passWordsql,moneysql FROM data_card  ";       //获取数据库数据
                    $querysql = $conn->query($sql);
                    foreach($querysql as $rs)       //遍历所取得的数据
	                {      
		                if($cardID_c == $rs['cardID']){
                            if($rs['statesql'] == 1) {
                                $find_c = true;
                                $next = 2;
                                $id_signsql_c = $rs['id'];        //获取相应的id
                                $name_signsql_c = $rs['namesql']; //获取相应的名字
                                $money_signsql_c = $rs['moneysql'];//获取相应的钱
                                $pw_signsql_c =  $rs['passWordsql'];//获取相应的密码
                            }else{
                                echo "该卡已经锁定!\n";
                                return 0;
                            }
                            $index_cardID++;
                        } 
                    }
                     
                    
                       while($next == 2 and !$find_s) {
                            echo "请输入对方的卡号:";
                            $cardID_s = fgets(STDIN);
                            $cardID_s = str_replace(PHP_EOL, '',  $cardID_s);

                            $sql = "SELECT id,cardID,statesql,namesql,passWordsql,moneysql FROM data_card  ";       //获取数据库数据
                            $querysql = $conn->query($sql);
                            foreach($querysql as $rs)       //遍历所取得的数据
	                        {      
		                        if($cardID_s == $rs['cardID']){
                                    if($rs['statesql'] == 1) {
                                        $find_s = true;
                                        $next = 3;
                                        $id_signsql_s = $rs['id'];        //获取相应的id
                                        $name_signsql_s = $rs['namesql']; //获取相应的名字
                                        $money_signsql_s = $rs['moneysql'];
                                    }else{
                                        echo "该卡已经锁定!\n";
                                        return 0;
                                    }
                                    $index_cardID++;
                                } 
                            }
                            if($find_s){
                                echo "对方的账户名为" . $name_signsql_s;
                                echo PHP_EOL;
                            }else {
                                echo "无此卡号,请重新输入\n";
                            }
                        }
                    


                    if ($next == 3) {
                        echo "确认转账请按1，任意键返回上一级!";
                        $next = fgets(STDIN);
                        $next = str_replace(PHP_EOL, '',  $next);
                        
                        if ($next == 1) {
                            $trans_sign = false;
                            do{
                                echo "请输入您要转账的金额:";
                                $money = fgets(STDIN);
                                $money = str_replace(PHP_EOL, '', $money); 

                                if($money < $money_signsql_c){
                                    $money_signsql_c = $money_signsql_c - $money;
                                    $money_signsql_s = $money_signsql_s + $money;
                                    $sql = "UPDATE  data_card SET moneysql = '$money_signsql_c'  WHERE id='$id_signsql_c'"; 
                                    $conn->exec($sql);
                                    $sql = "UPDATE  data_card SET moneysql = '$money_signsql_s'  WHERE id='$id_signsql_s'"; 
                                    $conn->exec($sql);
                                    echo "成功转账了".$money."元\n";
                                    $trans_sign = true;
                                }else{
                                    echo "余额不足,请重新输入\n";
                                }
                            }while(!$trans_sign);
                            
                        }
                    }
                    if($cardID_c != $rs['cardID'] && $index_cardID == 0){
                        echo "查无此号,请重新输入!\n";
                    }
                }
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }             
            }while(!$find_c);
            
        }
        //改密
        public function change_pwd()
        {
            //标记
            $frequency_sign = false;
            $find = false;
            do{   
                echo "请输入您的卡号:";
                $cardID = fgets(STDIN);
                $cardID = str_replace(PHP_EOL, '', $cardID);     
                try {
                    $index_cardID = 0;
                    global $conn;
                    $conn->query("set names 'utf8'");
    
                    $sql = "SELECT id,cardID,statesql,namesql,passWordsql,moneysql,phonesql FROM data_card  ";       //获取数据库数据
                    $querysql = $conn->query($sql);
                    foreach($querysql as $rs)       //遍历所取得的数据
	                {      
		                if($cardID == $rs['cardID']){
                            if($rs['statesql'] == 1) {
                                $find = true;
                                $id_signsql = $rs['id'];        //获取相应的id
                                $name_signsql = $rs['namesql']; //获取相应的名字
                                $money_signsql = $rs['moneysql'];//获取相应的钱
                                $pw_signsql =  $rs['passWordsql'];//获取相应的密码
                                $phone_sginsql = $rs['phonesql']; //获取相应的手机号
                            }else{
                                echo "该卡已经锁定!\n";
                                return 0;
                            }
                            $index_cardID++;
                        } 
                    }
                    if($find){
                        
                            echo "请输入您的手机号";
                            $phone_old = fgets(STDIN);
                            $phone_old = str_replace(PHP_EOL, '',  $phone_old);

                            do{
                                if($phone_old != $phone_sginsql){
                                    echo "手机号不一致，请重新输入！\n";
                                    echo "请输入您的手机号:";
                                    $phone_old = fgets(STDIN);
                                    $phone_old = str_replace(PHP_EOL, '',  $phone_old);
                                }
                                if($phone_old == $phone_sginsql ){     
                                    echo "请输入您新的密码";
                                    $pw_one = fgets(STDIN);
                                    $pw_one = str_replace(PHP_EOL, '', $pw_one);
                                
                                    echo "请确认您的新密码";
                                    $pw_two = fgets(STDIN);
                                    $pw_two = str_replace(PHP_EOL, '',  $pw_two);
    
                                    if ($pw_one != $pw_two) {
                                        echo "两次密码不一致，请重新输入！\n";
                                    } else {
                                        $sql = "UPDATE  data_card SET passWordsql = '$pw_one'  WHERE id='$id_signsql'"; 
                                        $conn->exec($sql);
                                        echo "修改成功\n";
                                        $frequency_sign = true;
                                    }
                                }
                            }while($phone_old == $phone_sginsql and $frequency_sign = false);      
                    }
                    
                    if($cardID != $rs['cardID'] && $index_cardID == 0){
                        echo "查无此号,请重新输入!\n";
                    }    
                }
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }             
            }while(!$find);
            
        }
        //锁卡
        public function lock()
        {
            //标记
            $frequency = 3;
            $find = false;
            do{   
                echo "请输入您的用户名:";
                $name_signsql = fgets(STDIN);
                $name_signsql = str_replace(PHP_EOL, '', $name_signsql);     
                try {
                    $index_namesql = 0;
                    global $conn;
                    $conn->query("set names 'utf8'");
    
                    $sql = "SELECT id,cardID,statesql,namesql,passWordsql,moneysql,phonesql,idCard,statesql FROM data_card  ";       //获取数据库数据
                    $querysql = $conn->query($sql);
                    foreach($querysql as $rs)       //遍历所取得的数据
	                {      
		                if($name_signsql == $rs['namesql']){
                            if($rs['statesql'] == 1) {
                                $find = true;
                                $id_signsql = $rs['id'];        //获取相应的id
                                $cardID_signsql = $rs['cardID']; //获取相应的卡号
                                $money_signsql = $rs['moneysql'];//获取相应的钱
                                $pw_signsql =  $rs['passWordsql'];//获取相应的密码
                                $phone_sginsql = $rs['phonesql']; //获取相应的手机号
                                $idCard_signsql = $rs['idCard'];  //获取相应的身份证号
                                $statesql_signsql = $rs['statesql']; //获取相应的状态
                            }
                            if($rs['statesql'] == 0) {
                                echo "卡已是锁住状态\n";
                                return 0;
                            }
                            $index_namesql++;
                        } 
                    }
                    
                    if($find){
                        while($frequency != 0){
                            echo "请输入您的身份证号:";
                            $idCard_old = fgets(STDIN);
                            $idCard_old = str_replace(PHP_EOL, '',  $idCard_old);

                            echo "请输入您的手机号:";
                            $phone_old = fgets(STDIN);
                            $phone_old = str_replace(PHP_EOL, '',  $phone_old);

                            if($idCard_old != $idCard_signsql and $phone_old == $phone_sginsql){
                                echo "身份证号匹配出错,请重新输入\n";
                                $frequency--;
                            }
                            if($idCard_old == $idCard_signsql and $phone_old != $phone_sginsql){
                                echo "手机号匹配出错,请重新输入\n";
                                $frequency--;
                            }
                            if($idCard_old == $idCard_signsql and $phone_old == $phone_sginsql){
                                echo "确认锁定请按1，任意键返回上一级！\n";
                                $next = fgets(STDIN);
                                $next = str_replace(PHP_EOL, '',  $next);

                                if ($next == 1) {
                                    $statesql_signsql = 0;
                                    $sql = "UPDATE  data_card SET statesql = '0'  WHERE id='$id_signsql'"; 
                                    $conn->exec($sql);
                                    echo "该卡已锁定!\n";
                                }
                                $frequency = 0;
                            } 
                            if($idCard_old != $idCard_signsql and $phone_old != $phone_sginsql){
                                    echo "核验信息有误,请重新输入\n";
                                    $frequency--;
                                }
                            }
                        }
                    if($name_signsql != $rs['namesql'] && $index_namesql == 0){
                        echo "查无用户,请重新输入!\n";
                    }    
                }
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }             
            }while(!$find);
            
        }
        //解卡
        public function unlock()
        {
            //标记
            $frequency = 3;
            $find = false;
            do{   
                echo "请输入您的用户名:";
                $name_signsql = fgets(STDIN);
                $name_signsql = str_replace(PHP_EOL, '', $name_signsql);     
                try {
                    $index_namesql = 0;
                    global $conn;
                    $conn->query("set names 'utf8'");
    
                    $sql = "SELECT id,cardID,statesql,namesql,passWordsql,moneysql,phonesql,idCard,statesql FROM data_card  ";       //获取数据库数据
                    $querysql = $conn->query($sql);
                    foreach($querysql as $rs)       //遍历所取得的数据
	                {      
		                if($name_signsql == $rs['namesql']){
                            if($rs['statesql'] == 0) {
                                $find = true;
                                $id_signsql = $rs['id'];        //获取相应的id
                                $cardID_signsql = $rs['cardID']; //获取相应的卡号
                                $money_signsql = $rs['moneysql'];//获取相应的钱
                                $pw_signsql =  $rs['passWordsql'];//获取相应的密码
                                $phone_sginsql = $rs['phonesql']; //获取相应的手机号
                                $idCard_signsql = $rs['idCard'];  //获取相应的身份证号
                                $statesql_signsql = $rs['statesql']; //获取相应的状态
                            }
                            if($rs['statesql'] == 1){
                                echo "该卡未锁!\n";
                                return 0;
                            }
                            $index_namesql++;
                        } 
                    }
                    
                    if($find){
                        while($frequency != 0){
                            echo "请输入您的身份证号:";
                            $idCard_old = fgets(STDIN);
                            $idCard_old = str_replace(PHP_EOL, '',  $idCard_old);

                            echo "请输入您的手机号:";
                            $phone_old = fgets(STDIN);
                            $phone_old = str_replace(PHP_EOL, '',  $phone_old);

                            if($idCard_old != $idCard_signsql and $phone_old == $phone_sginsql){
                                echo "身份证号匹配出错,请重新输入\n";
                                $frequency--;
                            }
                            if($idCard_old == $idCard_signsql and $phone_old != $phone_sginsql){
                                echo "手机号匹配出错,请重新输入\n";
                                $frequency--;
                            }
                            if($idCard_old == $idCard_signsql and $phone_old == $phone_sginsql){
                                echo "确认解锁请按1，任意键返回上一级!\n";
                                $next = fgets(STDIN);
                                $next = str_replace(PHP_EOL, '',  $next);

                                if ($next == 1) {
                                    $statesql_signsql = 0;
                                    $sql = "UPDATE  data_card SET statesql = '1'  WHERE id='$id_signsql'"; 
                                    $conn->exec($sql);
                                    echo "该卡已解锁!\n";
                                }
                                $frequency = 0;
                            } 
                            if($idCard_old != $idCard_signsql and $phone_old != $phone_sginsql) {
                                echo "核验信息有误,请重新输入\n";
                                $frequency--;
                            }
                        }
                    }
                    if($name_signsql != $rs['namesql'] && $index_namesql == 0){
                        echo "查无用户,请重新输入!\n";
                    }    
                }
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }             
            }while(!$find);
        }
        //补卡
        public function add()
        {
            $frequency = 3;
            $find = false;
            do{   
                echo "请输入您的用户名:";
                $name_signsql = fgets(STDIN);
                $name_signsql = str_replace(PHP_EOL, '', $name_signsql);     
                try {
                    $index_namesql = 0;
                    global $conn;
                    $conn->query("set names 'utf8'");
    
                    $sql = "SELECT id,cardID,statesql,namesql,passWordsql,moneysql,phonesql,idCard,statesql FROM data_card  ";       //获取数据库数据
                    $querysql = $conn->query($sql);
                    foreach($querysql as $rs)       //遍历所取得的数据
	                {      
		                if($name_signsql == $rs['namesql']){
                            $find = true;
                            $id_signsql = $rs['id'];        //获取相应的id
                            $cardID_signsql = $rs['cardID']; //获取相应的卡号
                            $idCard_signsql = $rs['idCard'];  //获取相应的身份证号
                            $statesql_signsql = $rs['statesql']; //获取相应的状态
                            $index_namesql++;
                        } 
                    }
                    
                    if($find){
                        echo "确认补卡请按1，任意键返回上一级！";
                        $next = fgets(STDIN);
                        $next = str_replace(PHP_EOL, '',  $next);
                        do{
                            echo "您的身份证号码:";
                            $idCard = fgets(STDIN);
                            $idCard = str_replace(PHP_EOL, '',  $idCard);
                            if($idCard === $idCard_signsql){
                                echo "您的原卡号为：" . $cardID_signsql . "\n";
                                echo "是否补办?(0/1)\n";
                                $sign = fgets(STDIN);
                                $sign = str_replace(PHP_EOL, '',  $sign);
                        
                                if($sign == 1){
                                    $cardID = rand(1000000, 9999999);
                                    $sql = "UPDATE  data_card SET cardID = '$cardID'  WHERE id='$id_signsql'"; 
                                    $conn->exec($sql);
                                    if($statesql_signsql == 0){
                                        $sql = "UPDATE  data_card SET statesql = '1'  WHERE id='$id_signsql'";
                                        $conn->exec($sql);
                                    }
                                    echo "补卡成功!您的卡号为：" . $cardID . "\n";
                                    $next = 0;
                                }
                            }
                            if($idCard == 0){
                                $next = 0;
                            }
                            if($idCard != $idCard_signsql){
                                echo "身份证配对出错,请重新输入!\n";
                            }
                        }while($next == 1 );
                }
                    if($name_signsql != $rs['namesql'] && $index_namesql == 0){
                        echo "查无用户,请重新输入!\n";
                    }    
                }
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }             
            }while(!$find);
            
        }   
    }  

?>
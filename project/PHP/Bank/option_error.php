<?php 
    namespace option;
    use index\main\login;



    class option {
        
        public $name = '';
        public $id = '';
        public $phone = '';
        public $pw_true = '';
        public $nu = 10000;
        public $money = 0;

            function name(){
                $name = fopen('php://stdin', 'r');
                $testName = fread($name, 12); //最多读取x个字符
                $testName = str_replace(PHP_EOL, '', $testName);
                $this->name = $testName;
                fclose($name);
                return $testName;
            }
            
            
            function id(){
                $id = fopen('php://stdin', 'r');
                echo "请输入您的身份证号:";
                $testId = fread($id, 18); //最多读取x个字符
                $this->id = $testId;
                fclose($id);
                return $testId;
            }
            
            
            function phone(){
                $phone = fopen('php://stdin', 'r');
                echo "请输入您的手机号:";
                $testPhone = fread($phone, 11); //最多读取x个字符
                $this->phone = $testPhone;
                fclose($phone);
                return $testPhone;
            }
            
            function nu(){
                $nu = $this->nu + 1;
                return $nu;
            }
            
            function money($x){
                $money = $this->money + $x;
                return $money;
            }
            function pw_true(){
                do{
                    $pw_one = fopen('php://stdin', 'r');
                    echo "请输入您的密码:";
                    $testPw_one = fread($pw_one, 12); //最多读取x个字符
                    fclose($pw_one);
        
                    $pw_two = fopen('php://stdin', 'r');
                    echo "请确认您的密码:";
                    $testPw_two = fread($pw_two, 12); //最多读取x个字符
                    fclose($pw_two);
    
                    if($testPw_one != $testPw_two){
                        echo "两次密码不一致,请重新输入!";
                        echo PHP_EOL;
                        
                    }
                }while($testPw_one != $testPw_two);
    
                $money = $this->money($this->money);
                $this->money = $money;
                if($testPw_one == $testPw_two){
                        $this->pw_true = $testPw_one;
                        $nu = $this->nu();
                        $this->nu = $nu;
                       return "恭喜您".$this->name."注册成功,您的卡号是".$this->nu.",卡内余额".$this->money."元";
                }
            }
            
            //开户   
            function open(){
                echo "请输入您的姓名:";
                $name = $this->name();
                $id = $this->id();
                $phone = $this->phone();
                $pw_true = $this->pw_true();
                echo $pw_true;
                
            }
            //存钱
            function save(){

                do{
                    $nu = $this->nu();
                    echo "请输入您的卡号:";
                    $testNu =  fgets(STDIN);
                    if($nu != $testNu){
                     echo "请重新输入";
                    break;
                    }
                }while($nu != $testNu);

                do{
                    $name = $this->name();
                    echo "您输入的账户名为:";
                    $testName = fgets(STDIN);
                    if($name != $testName){
                        echo "请重新输入";
                        echo PHP_EOL;
                    }
                }while($name != $testName);
            }
        
    }
   
        
        do{
            //new新对象
            $option = new option();
            echo "请选择需要办理的业务:";
            $option_nu  = fgets(STDIN);
            switch($option_nu){
                case 1:
                    //打印对象里的函数
                    echo $option->open();
                    echo PHP_EOL;
                    break;
                case 3:
                    //打印对象里的函数
                    echo $option->save();
                    echo PHP_EOL;
                    break;    
                default:
                    echo "?";
                    break;
            }


            // if($option_nu != 0){
            //     //new新对象
            //     $login = new login();
            //     //打印对象里的函数
            //     echo $login->view();  
            // }
        }while($option_nu != 0);
        
       

?>
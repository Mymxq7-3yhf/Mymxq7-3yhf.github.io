<?php 
    namespace index\main;

    class login {
        public function view(){
            echo "----------------------------------";
            echo PHP_EOL;
            echo "|         兄弟会银行欢迎您       |";
            echo PHP_EOL;
            echo "----------------------------------";
            echo PHP_EOL;
            echo "|     1.开户     |     2.查询    |";
            echo PHP_EOL;
            echo "----------------------------------";
            echo PHP_EOL;
            echo "|     3.存钱     |     4.取钱    |";
            echo PHP_EOL;
            echo "----------------------------------";
            echo PHP_EOL;
            echo "|     5.转账     |     6.改密    |";
            echo PHP_EOL;
            echo "----------------------------------";
            echo PHP_EOL;
            echo "|     7.锁卡     |     8.解卡    |";
            echo PHP_EOL;
            echo "----------------------------------";
            echo PHP_EOL;
            echo "|     9.补卡     |     0.退出    |";
            echo PHP_EOL;
            echo "----------------------------------";
            echo PHP_EOL;
        }
        
    }
    //new新对象
    $login = new login();
    //打印对象里的函数
    echo $login->view();
    require("all.php");
    
    
?>
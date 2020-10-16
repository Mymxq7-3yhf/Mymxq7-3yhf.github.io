<?php 
    namespace main;
    
    $glzhanghao = "admin";
    $zhanghao = fopen('php://stdin', 'r');
    echo "请输入管理员账号:";
    $testZhanghao = fread($zhanghao, 6); //最多读取x个字符
    fclose($zhanghao);
    
    // $test111 = ($testZhanghao = $glzhanghao) ? 123 : 111;
    // echo "$test111";

    $glmima = 123;
    $mima = fopen('php://stdin', 'r');
    echo "请输入管理员密码:";
    $testMima = fread($mima, 6); //最多读取x个字符
    fclose($mima);


    // $demo = fopen('php://stdin', 'r');
    // echo "请输入: ";
    // $test = fread($demo, 12); //最多读取12个字符
    // echo sprintf("输入为: %s\n", $test);fclose($demo);

    if( $testZhanghao = $glzhanghao &&  $testMima == $glmima ){
        require("index.php");
    }else {
        echo "?";
        echo PHP_EOL;
    }


?>
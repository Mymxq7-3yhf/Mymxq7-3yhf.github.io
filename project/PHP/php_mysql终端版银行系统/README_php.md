> 这里我将 php 连接数据库的代码单独写在了 link.php 文件,其他 php 文件需要使用,可在代码最上面`require_once 'link.php';` 进行使用

```
link.php
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "bank_sql";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            echo "连接成功\n";
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }

```

- php 读取数据库数据,对数据进行操作

  > 实例(取钱)

  1. 获取数据库数据

  ```
    global $conn;
    $conn->query("set names 'utf8'");

    $sql = "SELECT id,cardID,statesql,namesql,passWordsql,moneysql FROM data_card  ";       //获取数据库数据
    $querysql = $conn->query($sql);
  ```

  2. 遍历所取得的数据,并在遍历时对所遍历的数据进行条件判断(Eg.这里判断数据库是否有对应的卡号,如果有,则将相应行的所需要的数据定义变量赋值取出来)

  ```
    foreach($querysql as $rs)       //遍历所取得的数据
    {   //对遍历的数据库数据进行条件判断
  	    if($cardID == $rs['cardID']){
            if($rs['statesql'] == 1) {          //判断卡是否锁定
                $find = true;
                $id_signsql = $rs['id'];        //获取相应的id
                ...
            }else{
                echo "该卡已经锁定!\n";
                return 0;
            }
        }
    }
  ```

  3. 将功能流程顺利实现以后,把值更新进数据库

  ```
    $sql = "UPDATE data_card SET moneysql = '$money_signsql' WHERE id='$id_signsql'";

    $conn->exec($sql);
  ```

- 源代码

```
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
	            {   //对遍历的数据库数据进行条件判断
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
                                    $conn->exec($sql);                  //将数据库数据更新
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

```

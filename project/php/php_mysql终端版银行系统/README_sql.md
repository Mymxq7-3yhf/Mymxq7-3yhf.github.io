```
//创建用户信息表,卡号为唯一标识
create table data_card
(
    id int auto_increment primary key,
    cardID char(7) unique, //卡号
    moneysql decimal(10,2), //余额
    statesql int(1), //状态
    namesql varchar(64) , //姓名
    passWordsql varchar(32), //密码
    idCard nvarchar(20), //身份证
    phonesql char(11), //手机号
    addTime datetime //创建时间
    )ENGINE=InnoDB AUTO_INCREMENT=3701 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

    insert into data_card(cardID,moneysql,statesql,namesql,passWordsql,idCard,phonesql,addTime)
       values("0000000","0","1","管理员","123456","000000000000000000","15878576414",now());
```

- 创建数据库,创建新表(原始数据)

```
create database bank_sql default character set utf8 collate utf8_general_ci;
use bank_sql;

create table data_admin
    (
        id int auto_increment primary key,
        userName varchar(7) ,
        passWordsql varchar(7),
        addTime datetime
    )ENGINE=InnoDB AUTO_INCREMENT=01 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    insert into data_card(userName,passWordsql,addTime)
       values("管理员","123",now());

create table data_card
    (
        id int auto_increment primary key,
        cardID  char(7) unique,
        moneysql   decimal(10,2),
        statesql   int(1),
        namesql varchar(64) ,
        passWordsql varchar(32),
        idCard nvarchar(20),
        phonesql char(11),
        addTime datetime
    )ENGINE=InnoDB AUTO_INCREMENT=3701 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    insert into data_card(cardID,moneysql,statesql,namesql,passWordsql,idCard,phonesql,addTime)
       values("0000000","0","1","管理员","123456","000000000000000000","15878576414",now());
    insert into data_card(cardID,moneysql,statesql,namesql,passWordsql,idCard,phonesql,addTime)
       values("7777777","777","1","余泓锋","123456","622848084837380678","15878576414",now());
```

- 数据库 character_set_server 不是 utf8
  进入数据库 show variables like '%char%';

  > ps!!!使用命令 set character_set_server=utf8;

- 终端显示数据库数据中文是问号

```
解决方案：
    在代码里，在执行select语句之前，加上
        mysql_query("set names 'utf8'");
    注意，mysql数据库也要设置utf8，浏览器显示和文件类型都设置为utf-8;
设置utf8原因：
    UTF-8(8-bit Unicode Transformation Format)是一种针对Unicode的可变长度字符编码，又称万国码。由Ken Thompson于1992年创建。现在已经标准化为RFC 3629。UTF-8用1到6个字节编码UNICODE字符。用在网页上可以同一页面显示中文简体繁体及其它语言(如英文，日文，韩文)。
Eg. 在php中遍历输出写法
    $dbh->query("set names 'utf8'");
    foreach ($dbh->query('SELECT * from data_card') as $row) {
        print_r($row); //你可以用 echo($GLOBAL); 来看到这些值
    }
    =>  set names 'utf8;    SELECT * from data_card;

```

### 环境确认(以下都是在 ubuntu18.04 下进行的)

- 查询 php 版本
  > php -v(这里我使用的 php 是 7.2.24 版本)

```
PHP 7.2.24-0ubuntu0.18.04.6 (cli) (built: May 26 2020 13:09:11) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.2.0, Copyright (c) 1998-2018 Zend Technologies
    with Zend OPcache v7.2.24-0ubuntu0.18.04.6, Copyright (c) 1999-2018, by Zend Technologies

```

> 安装 php 原文链接：https://www.blog8090.com/ubuntu18-04-lnmphuan-jing-cong-ling-da-jian/

#### 如果没有 php,请按照如下步骤进行 php 安装

- 安装 PHP7.2

```
# 安装PHP7.2
sudo apt-get install -y php7.2

# 安装成功后
php -v

#出现一下内容为成功

#PHP 7.2.24-0ubuntu0.18.04.1 (cli) (built: Oct 28 2019 12:07:07) ( NTS )
Copyright (c) 1997-2018 The PHP Group
```

- 安装 PHP7.2 相关扩展

```
sudo apt-get install -y php7.2-fpm php7.2-mysql php7.2-curl php7.2-json php7.2-mbstring php7.2-xml php7.2-intl php7.2-zip php7.2-gd php7.2-opcache php7.2-common php7.2-cli

```

- 配置 php.ini 和设 ​​ 置的 PHP-FPM 自启动

1.

```
    vim /etc/php/7.2/fpm/php.ini
```

2. 搜索`cgi.fix_pathinfo =`，在`; cgi.fix_pathinfo = 1`一行后面添加一行`cgi.fix_pathinfo = 0`，要有一个好的习惯，修改配置文件的时候，能不动源码的时候尝试不动，防备于未然。
   > vim 搜索使用`/`来搜索，例如上面搜索的内容`/ cgi.fix_pathinfo =`来搜索，使用 N 继续下一条

```
    ; http://php.net/cgi.fix-pathinfo
    ;cgi.fix_pathinfo=1
    cgi.fix_pathinfo=0
```

- 设置 php-fpm 自启动（如果你有 systemctl 守护进程服务）

```
    systemctl start php7.2-fpm
    systemctl enable php7.2-fpm

    # 如果你没有systemctl，请输入下面命令
    sudo service php7.2-fpm restart
```

- 检查 php-fpm 是否安装成功

```
    netstat -pl | grep php7.2-fpm
```

### 数据库操作

- 查询数据库版本
  > mysql --version

```
    mysql  Ver 14.14 Distrib 5.7.31, for Linux (x86_64) using  EditLine wrapper
```

> 安装 mysql 原文链接：https://www.blog8090.com/ubuntu18-04-lnmphuan-jing-cong-ling-da-jian/

#### 如果没有 mysql,请按照如下步骤进行 mysql 安装

- 安装 MySQL5.7
  Ubuntu18.04 不用选择 mysql 的安装版本，交替就是最新的 mysql，在这里我使用的版本是 mysql5.7

```
    sudo apt-get install mysql-server mysql-client
```

- 安装完成后查看 mysql 版本

```
    mysql --version

    # 安装过程中，如果提示输入 root 密码，直接设置就行（我的安装过程中没有出现提示）；

    # 若安装过程没有提示输入 root 密码，则需要安装完之后，手动重置 root 密码
```

#### ubuntu18.04 首次登录 mysql 未设置密码或忘记密码解决方法

> 链接:https://blog.csdn.net/qq_38737992/article/details/81090373#commentBox

#### 可安装 navicat 数据库管理和设计工具

##### Navicat 连接 Mysql 报错：2002 can't connect to mysql server through socket '/var/lib/mysql.socket'

> 链接:https://www.jianshu.com/p/1fdeb2e5b25a

### 操作

1. 进入数据库(参考)
   > mysql -h localhost -uroot -proot (终端下输入)
2. 查询所有库 (数据库终端下输入)
   > show databases;
3. 创建库 (数据库终端下输入)
   > create database bank_sql default character set utf8 collate utf8_general_ci;
4. 进入相应库 (数据库终端下输入)
   > use bank_sql;
5. 创建所需表(可参考 README_sql.md)
6. 执行 php 项目
   > php main.php

PS.小白牙牙学语版代码,有着很大的代码升级优化空间,Eg.封装函数,继承等,很高兴能跟大家分享所学知识,一起学习,共同进步!

**php 终端版银行系统**

- 安装参考

> https://www.blog8090.com/ubuntu18-04-lnmphuan-jing-cong-ling-da-jian/

> https://www.blog8090.com/ubuntu18-04-lnmphuan-jing-er-la/

Ps.

1. 要注意文件权限问题 Eg.sudo chmod 777 xxx
2. nginx 的配置问题

```
    cd /etc/nginx/sites-available/
或者
    cd /etc/nginx/sites-enabled/

    sudo cp default demo.conf

    sudo vim demo.conf
```

3. php 文件所在位置

```
    cd  /etc/php/
```

-

1. 使用`php main.php`命令
2. 管理员帐号`admin` 管理员密码`123`(在 main.php 文件中可以修改)

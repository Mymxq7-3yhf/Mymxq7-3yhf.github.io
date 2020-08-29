github 远程仓库与本地相连

> https://blog.csdn.net/qq_28413435/article/details/83018194

> https://www.cnblogs.com/shaozheng/p/12173669.html


```
ssh-keygen -t rsa -C "youremail@example.com"
邮箱可以随便填

```

> https://www.cnblogs.com/esllovesn/p/12100523.html

```
重要的是SSH Key
创建一个SSH Key：ssh-keygen -t rsa -C "your_email@example.com"
-t 指定密钥类型，默认是 rsa ，可以省略。
-C 设置注释文字，比如邮箱。
-f 指定密钥文件存储文件名。

将id_rsa.pub文件复制，放到github上
```
> //获取仓库

1.git init

2.git clone http://xxx

//三个区：工作区（working）、暂存区（staging）、历史仓库(history)

git add 文件名 （添加文件到暂存区）Eg.git add README.md

git commit -m "添加的说明" （提交到暂存区）

git push -u origin master (将代码推送到远端）

3.添加分支

git branch -b xxx 
4.删除分支

git branch -d xxx 
5.切换分支

git checkout xxx






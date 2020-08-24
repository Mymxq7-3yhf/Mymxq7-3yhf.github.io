github 远程仓库与本地相连

> https://blog.csdn.net/qq_28413435/article/details/83018194

> //获取仓库

1.git init

2.git clone http://xxx

//三个区：工作区（working）、暂存区（staging）、历史仓库(history)

git add 文件名 （添加文件到暂存区）Eg.git add README.md

git commit -m "添加的说明" （提交到暂存区）

git push -u origin master (将代码推送到远端）

3.添加分支

git branch -b xxx 4.删除分支

git branch -d xxx 4.切换分支

git checkout xxx

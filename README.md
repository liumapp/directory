# directory

> yii2框架下对于目录及目录下文件操作的工具

##使用方法

     $lmD = new Directory();
     $lmD->basePath = '/usr/local/var/www/';
     $lmD->buildPath('img/a' , 0755);
     $lmD->buildPath('img/b' , 0755);
     $lmD->buildPath('img/c' , 0755);
     $lmD->buildFile('img/a/a.txt' , 0755);
     $lmD->buildFile('img/b/b.txt' , 0755);
     $lmD->buildFile('img/c/c.txt' , 0755);
     $lmD->removeDirs('img/' , ['a']);//img目录下除了a目录以外其他目录全部删除掉
     
     
> 上述代码执行后会产生一个/usr/local/var/www/img/a/a.txt文件，b.txt和c.txt存在过，但之后被删除了。

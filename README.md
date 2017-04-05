# directory

> php下对于目录及目录下文件操作的工具

## 使用方法

### 目录及文件的创建
     $lmD = new Directory();
     $lmD->setBasePath('/usr/local/var/www/');
     $lmD->buildPath('img/a' , 0755);
     $lmD->buildPath('img/b' , 0755);
     $lmD->buildPath('img/c' , 0755);
     $lmD->buildFile('img/a/a.txt' , 0755);
     $lmD->buildFile('img/b/b.txt' , 0755);
     $lmD->buildFile('img/c/c.txt' , 0755);
     $lmD->removeDirs('img/' , ['a']);//img目录下除了a以外其他全部删除掉
     
     
> 上述代码执行后会产生一个/usr/local/var/www/img/a/a.txt文件，b.txt和c.txt存在过，但之后被删除了。

### 文件的打开与写入

    $time = time();
    $date = date('YmdH' , $time);
    $fileName = 'tmp' . $time  . rand(100 , 999). '.html';
    $directory =  new Directory();
    $directory->file = new File();
    $directory->setBasePath(Yii::getAlias('@vendor') . '/liumapp/dompdf/www/data');
    $directory->buildPath($date);
    $directory->buildFile($date . '/' . $fileName);
    $directory->file->setFileName($directory->getAbsolutPath($date . '/' . $fileName));

    $string = 'this is the one must be done';
    $directory->file->open()->write($string);
   
> 上述代码执行后会产生一个/usr/local/var/www/vendor/liumapp/dompdf/www/data/2017091402/tmp1491356100.html的文件，文件内容是'this is the one you must be done'.

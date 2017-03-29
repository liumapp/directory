<?php
/**
 * Created by PhpStorm.
 * User: liumapp.com
 * contact: liumapp.com@gmail.com
 * Date: 3/29/17
 * Time: 5:07 PM
 */
namespace huluwa\directory;

class Directory
{
    public $basePath = '/';

    public function getAbsolutPath ($path)
    {

    }

    public function buildPath ($path = '', $permission = 0755)
    {
        $path = $this->basePath . $path;
        if (!file_exists($path)) {
            mkdir($path);
            chmod($path , $permission);
        }
    }

    public function buildFile ($path , $permission)
    {

    }

    public function removeDirs ($path , array $except)
    {

    }

    protected function prepareFile ()
    {
        $base = \Yii::getAlias('@frontend') . '/web/';
        $time = time();
        $date = date('YmdH' , $time);

        if (!file_exists($base . 'img/')) {
            mkdir($base . 'img/');
            chmod($base . 'img/' , 0777);
        }

        if (!file_exists($base . 'img/' . $date)) {
            mkdir($base . 'img/' . $date);
            chmod($base . 'img/' . $date , 0777);
        }

        $fileName = $base . 'img/' . $date . '/code' . $time . '.png';
        $file = fopen( $fileName, 'w+b');
        fclose($file);
        chmod($fileName , 0777);
        $this->codeUrl = './img/' . $date . '/code' . $time . '.png';

        $this->deleteDirs(scandir($base . 'img/') , [$date , '.' , '..'] , $base . 'img/');

        return $fileName;
    }

    private function deleteDirs ($dirs , $except , $basePath)
    {
        foreach ($dirs as $dir) {
            if (! in_array($dir , $except)) {
                $this->deleteDir($dir , $basePath);
            }
        }
    }

    private function deleteDir ($dir , $basePath)
    {
        $name = opendir($basePath . $dir);
        while($file = readdir($name)) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_file($basePath . $dir . '/' . $file)) {
                unlink($basePath . $dir . '/' . $file);
            }

        }
        rmdir($basePath . $dir);
    }

}
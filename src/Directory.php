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
    protected $basePath = '/';

    public function setBasePath ($basePath)
    {
        $this->basePath = $basePath;
        $this->chkBasePath();
    }

    public function getAbsolutPath ($path)
    {
        return $this->basePath . $path;
    }

    public function chkBasePath ()
    {
        $begin = substr($this->basePath , 0, 1);
        $length = strlen($this->basePath);
        $end = substr($this->basePath , $length - 1 , $length);

        if ($begin != '/') {
            throw new \ErrorException('不合法的根路径');
        }

        if ($end != '/') {
            $this->basePath = $this->basePath . '/';
        }

    }

    /**
     * path 应该以相对路径的形式传入
     * @param $path
     */
    public function chkPath ($path)
    {
        $begin = substr($path , 0 , 1);
        $second = substr($path , 0 , 2);
        $length = strlen($path);
        $end = substr($path , $length - 1 , $length);

        if ($begin == '/') {
            throw new \ErrorException('不合法的相对路径，传入的path值必须是相对路径');
        }

        if ($second == './') {
            $path = str_replace('./' , '' , $path);
        }

        if ($end == '/') {
            $array = str_split($path);
            array_pop($array);
            $path = implode('' , $array);
        }
        return $path;
    }

    public function strip ($dir)
    {
        return array_diff(explode('/' , $dir) , explode('/' , $this->basePath));
    }


    public function buildPath ($path = '', $permission = 0777)
    {
        $path = $this->chkPath($path);
        $dir = $this->basePath . $path;
        $stripDirs = $this->strip($dir);
        return $this->chkDir($stripDirs , $permission);
    }

    public function buildFile ($path , $permission = 0777)
    {
        $path = $this->chkPath($path);
        $stripDirs = $this->strip($this->basePath . $path);
        $fileName = array_pop($stripDirs);
        $path = $this->chkDir($stripDirs);

        if (!file_exists($path . $fileName)) {
            $file = fopen($path . $fileName , 'w+b');
            fclose($file);
            chmod($path . $fileName , $permission);
        }
    }

    public function removeDirs ($path , array $except = [])
    {
        $stripDirs = $this->strip($this->basePath . $path);
        $tmp = $this->chkDir($stripDirs);
        $dirs = scandir($tmp);
        foreach ($dirs as $dir) {
            if (! in_array($dir , $except)) {
                if ($dir == '.' || $dir == '..') {
                    continue;
                }
                $this->removeDir($tmp . $dir);
            }
        }
    }

    public function removeDir ($path)
    {
        $name = opendir($path);
        while ($file = readdir($name)) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_file($path . '/' . $file)) {
                unlink($path . '/' . $file);
            }
            if (is_dir($path . '/' . $file)) {
                $this->removeDir($path . '/' . $file);
            }
        }
        return rmdir($path);
    }

    protected function chkDir (array $stripDirs , $permission = 0777)
    {
        $tmp = $this->basePath;
        foreach ( $stripDirs as $stripDir ) {

            if (!file_exists($tmp . $stripDir )) {
                mkdir($tmp . $stripDir);
                chmod($tmp . $stripDir, $permission);
            }
            $tmp = $tmp . $stripDir . '/';

        }
        return $tmp;
    }


}
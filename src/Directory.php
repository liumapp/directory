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
        return $this->basePath . $path;
    }

    public function chkBasePath ()
    {
        
    }

    public function chkPath ()
    {

    }

    public function strip ($dir)
    {
        return array_diff(explode('/' , $dir) , explode('/' , $this->basePath));
    }


    public function buildPath ($path = '', $permission = 0777)
    {
        $dir = $this->basePath . $path;
        $stripDirs = $this->strip($dir);
        return $this->chkDir($stripDirs , $permission);
    }

    public function buildFile ($path , $permission = 0777)
    {
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
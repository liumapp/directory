<?php
/**
 * Created by PhpStorm.
 * User: liumapp.com
 * contact: liumapp.com@gmail.com
 * Date: 4/1/17
 * Time: 3:42 PM
 * operation files
 */

namespace huluwa\directory\file;

class File
{
    protected $fileName;

    protected $instance = null;

    public function setFileName ($fileName)
    {
        $this->fileName = $fileName;
    }

    public function getFileName ()
    {
        return $this->fileName;
    }

    public function open ($type = 'w+b')
    {
        $this->instance = fopen($this->fileName , $type);
        return $this;
    }

    public function clean ()
    {
        fclose(fopen($this->fileName , 'w+b'));
    }

    public function write ($content = '')
    {
        fwrite($this->instance , $content);
        return $this;
    }

    public function close ()
    {
        fclose($this->instance);
        return $this;
    }

}



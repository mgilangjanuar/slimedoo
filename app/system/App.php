<?php

/**
* Cosmic class
*/
class App
{
    /**
    * Slim app variable. Access this statically like \App:$app
    */
    public static $app;

    protected static $url = '';

    protected static $db = [];

    /** 
    * Main function for initialize this class.
    * @param \Slim\Slim
    */ 
    public static function init(\Slim\Slim $slim)
    {
        require 'app/config/config.php';
        static::$app = $slim;
        static::$url = $config['url'];
        static::$db  = $config['db'];
    }

    /** 
    * Get medoo object for database communication.
    * @return \medoo
    */ 
    public static function db()
    {
        return new medoo(static::$db);
    }

    /** 
    * Get absolute URL.
    * @param $value=''
    * @return string
    */ 
    public static function url($value='')
    {
        return static::$url . $value;
    }

    /** 
    * Get realpath directory.
    * @param $value=''
    * @return string
    */ 
    public static function path($value='')
    {
        return realpath($value);
    }

    /** 
    * Get name of class with namespace.
    * @return string
    */ 
    public static function className()
    {
        return get_called_class();
    }

    /**
    * Get array of real path files location in a directory recursively. With
    * real path of directory location in this parameter, you can use path() 
    * function for get it.
    * @param $dir
    * @param &$results=[]
    * @return []
    */ 
    public static function getDirContents($dir, &$results=[]){
        $files = scandir($dir);
        foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if(!is_dir($path)) {
                $results[] = $path;
            } else if(is_dir($path) && $value != "." && $value != "..") {
                $results[] = $path;
                App::getDirContents($path, $results);
            }
        }
        return $results;
    }
}
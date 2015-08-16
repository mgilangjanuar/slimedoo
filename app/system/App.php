<?php

/**
* App class.
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
        static::$app = $slim;
        static::$url = static::config()->dir;
        static::$db  = static::config()->db;
    }

    /** 
    * Load variable config in app/config/config.php and returned as object.
    * @return object
    */
    public static function config()
    {
        require 'app/config/config.php';
        return (object) $config;
    }

    /**
    * Load variable params in app/config/params.php and returned as object.
    * @return object
    */
    public static function params()
    {
        require 'app/config/params.php';
        return (object) $params;
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
        return 'http://' . $_SERVER['HTTP_HOST'] . static::$url . ($value != null ? '/' : '') . $value;
    }

    /** 
    * Get real path directory or a file.
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
    * Get current route.
    * @return string
    */
    public static function activeRoute()
    {
        return static::$app->router()->getCurrentRoute()->getPattern();
    }

    /**
    * Get array of real path files location in a directory recursively. With
    * real path of directory location in this parameter, you can use path() 
    * function for get it.
    * @param $dir
    * @param &$results=[]
    * @return []
    */ 
    public static function dirContents($dir, &$results=[])
    {
        $files = scandir($dir);
        foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if(!is_dir($path)) {
                $results[] = $path;
            } else if(is_dir($path) && $value != "." && $value != "..") {
                $results[] = $path;
                static::dirContents($path, $results);
            }
        }
        return $results;
    }

    /** 
    * This function for facilitated autoload file(s) in a directory like css,
    * js, or other files.
    * @param $dir
    * @param $ext=null
    * @param $withWebUrl=false
    * @return []
    */ 
    public static function autoload($dir, $ext=null, $withWebUrl=false)
    {
        $results = [];
        foreach (static::dirContents($dir) as $file) {
            if ($ext == null || ($ext !=null && strpos(basename($file), $ext))) {
                if ($withWebUrl) {
                    $results[] = str_replace(static::path(), static::url(), $file);
                } else {
                    $results[] = str_replace(static::path() . '/', '', $file);
                }
            }
        }
        return $results;
    }
}
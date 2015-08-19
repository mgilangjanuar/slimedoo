<?php 

class Assets
{
    public static function load($func)
    {
        if (method_exists(get_called_class(), $func)) {
            foreach (static::$func() as $file) {
                $load = $func . 'Load';
                echo static::$load($file);
            }
        } else {
            throw new Exception('Error load ' . $func . '. Go to app/component/Assets.php for resolve this.');
            
        }
    }

    protected static function dir()
    {
        return \App::url('web/assets/');
    }

    protected static function css()
    {
        return [
            'app/site.css',
            'bootstrap/css/bootstrap.css',
            'fontawesome/css/font-awesome.min.css',
            'simple-sidebar/sidebar.css',
        ];
    }

    protected static function js()
    {
        return [
            'jquery/jquery.min.js',
            'bootstrap/js/bootstrap.min.js',
            'simple-sidebar/toggle-sidebar.js',
        ];
    }

    protected static function cssLoad($location)
    {
        return '<link rel="stylesheet" href="' . static::dir() . $location . '">';
    }

    protected static function jsLoad($location)
    {
        return '<script src="' . static::dir() . $location . '"></script>';
    }
}
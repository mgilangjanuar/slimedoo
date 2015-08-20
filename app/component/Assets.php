<?php 

class Assets
{
    public static function dir()
    {
        return \App::url('web/assets/');
    }

    public static function css()
    {
        return [
            'app/site.css',
            'bootstrap/css/bootstrap.css',
            'fontawesome/css/font-awesome.min.css',
            'simple-sidebar/sidebar.css',
        ];
    }

    public static function js()
    {
        return [
            'jquery/jquery.min.js',
            'bootstrap/js/bootstrap.min.js',
            'simple-sidebar/toggle-sidebar.js',
        ];
    }

    public static function cssLoad($location)
    {
        return '<link rel="stylesheet" href="' . static::dir() . $location . '">';
    }

    public static function jsLoad($location)
    {
        return '<script src="' . static::dir() . $location . '"></script>';
    }
}
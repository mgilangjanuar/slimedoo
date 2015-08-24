<?php 

class Assets
{
    public $additionalCss = [];

    public $additionalCssFile = [];
    
    public $additionalJs = [];

    public $additionalJsFile = [];

    public function dir()
    {
        return \App::url('web/assets/');
    }

    public function addCss($css)
    {
        if (! in_array($css, $this->additionalCss)) {
            $this->additionalCss[] = $css;
        }
    }

    public function addCssFile($css)
    {
        if (! in_array($css, $this->additionalCss)) {
            $this->additionalCssFile[] = $css;
        }
    }

    public function addJs($js)
    {
        if (! in_array($js, $this->additionalJs)) {
            $this->additionalJs[] = $js;
        }
    }

    public function addJsFile($js)
    {
        if (! in_array($js, $this->additionalJs)) {
            $this->additionalJsFile[] = $js;
        }
    }

    public function css()
    {
        return [
            'app/site.css',
            'bootstrap/css/bootstrap.css',
            'fontawesome/css/font-awesome.min.css',
            'simple-sidebar/sidebar.css',
        ];
    }

    public function js()
    {
        return [
            'jquery/jquery.min.js',
            'bootstrap/js/bootstrap.min.js',
            'simple-sidebar/toggle-sidebar.js',
        ];
    }

    public function cssLoad($location)
    {
        return '<link rel="stylesheet" href="' . static::dir() . $location . '">';
    }

    public function jsLoad($location)
    {
        return '<script src="' . static::dir() . $location . '"></script>';
    }
}
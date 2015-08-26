<?php 

class Assets
{
    public $css = [];

    public $js = [];

    public $cssFile = [];
    
    public $jsFile = [];

    public $dir;

    public function __construct()
    {
        $this->dir = \App::url('web/assets/');
    }

    public function addCss($css)
    {
        if (! in_array($css, $this->css)) {
            $this->css[] = $css;
        }
    }

    public function addCssFile($css)
    {
        if (! in_array($css, $this->cssFile)) {
            $this->cssFile[] = $css;
        }
    }

    public function addJs($js)
    {
        if (! in_array($js, $this->js)) {
            $this->js[] = $js;
        }
    }

    public function addJsFile($js)
    {
        if (! in_array($js, $this->jsFile)) {
            $this->jsFile[] = $js;
        }
    }

    public function cssLoad($location)
    {
        return '<link rel="stylesheet" href="' . $this->dir . $location . '">';
    }

    public function jsLoad($location)
    {
        return '<script src="' . $this->dir . $location . '"></script>';
    }
}
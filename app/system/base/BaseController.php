<?php

use \App;

class BaseController extends App
{
    public $layout;

    public $title;

    public function __construct()
    {
        $this->layout = 'app/views/layouts/main.php';
    }

    public function routes()
    {
        $results = [];
        foreach (get_class_methods(static::className()) as $func) {
            if (substr($func, 0, 6) == 'action') {

                // collect arguments
                $valTmp = '';
                $r = new \ReflectionMethod(static::className(), $func);
                $params = $r->getParameters();
                foreach ($params as $param) {
                    $valTmp .= '/:' . $param->getName();
                }

                // check if this function is default function
                if ($func == static::config()->defaultFunction) {
                    $results['/' . $this->viewDir() . $valTmp] = static::className() . ':' . $func;
                }
                $results['/' . $this->viewDir() . '/' . $this->dashesFormat(substr($func, 6)) . $valTmp] = static::className() . ':' . $func;
            }
        }
        return $results;
    }

    public function viewDir()
    {
        $className = str_replace('\\', '/', static::className());
        $className = str_replace('app/controllers/', '', $className);
        $className = str_replace('Controller', '', $className);
        return $this->dashesFormat($className);
    }

    public function dashesFormat($value)
    {
        // http://stackoverflow.com/questions/10507789/camelcase-to-dash-two-capitals-next-to-each-other
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $value));
    }

    public function render($__content, $data=[])
    {
        $__content = 'app/views/' . $this->viewDir() . '/' . $__content . (strpos($__content, '.') ? '' : '.php');
        extract($data);
        require $this->layout;
    }

    public function redirect($url='')
    {
        static::$app->response->redirect($this->siteUrl($url));
    }

    public function siteUrl($url='')
    {
        return static::url($this->viewDir() . ($url != null ? '/' : '') . $url);
    }
}
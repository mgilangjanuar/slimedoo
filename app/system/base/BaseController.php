<?php

use \App;

class BaseController extends App
{
    public $layout;

    public $title;

    public $publicFunction;

    public $defaultFunction;

    public function __construct()
    {
        $this->layout = 'app/views/layouts/main.php';
        $this->publicFunction = 'action';
        $this->defaultFunction = 'index';
    }

    public function rules()
    {
        return [
            // Example
            // 'auth' => [
            //     '@' => ['dashboard', 'profile'],
            //     'admin' => ['admin'],
            // ],
        ];
    }

    public function routes()
    {
        $results = [];
        foreach (get_class_methods(static::className()) as $func) {
            if (substr($func, 0, strlen($this->publicFunction)) == $this->publicFunction) {

                // collect arguments
                $valTmp = '';
                $r = new \ReflectionMethod(static::className(), $func);
                $params = $r->getParameters();
                foreach ($params as $param) {
                    $valTmp .= '/:' . $param->getName();
                }

                // check if this function is default function
                if ($func == $this->publicFunction . ucfirst($this->defaultFunction)) {
                    $results['/' . $this->viewDir() . $valTmp] = static::className() . ':' . $func;
                }
                $results['/' . $this->viewDir() . '/' . $this->dashesFormat(substr($func, strlen($this->publicFunction))) . $valTmp] = static::className() . ':' . $func;
            }
        }
        return $results;
    }

    protected function viewDir()
    {
        $className = str_replace('\\', '/', static::className());
        $className = str_replace('app/controllers/', '', $className);
        return $this->dashesFormat($className);
    }

    protected function dashesFormat($value)
    {
        // http://stackoverflow.com/questions/10507789/camelcase-to-dash-two-capitals-next-to-each-other
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $value));
    }

    protected function callerAction()
    {
        return lcfirst(substr(debug_backtrace()[2]['function'], strlen($this->publicFunction)));
    }

    public function render($__content, $data=[])
    {
        $__content = 'app/views/' . $this->viewDir() . '/' . $__content . (strpos($__content, '.') ? '' : '.php');
        extract($data);

        $roles = [];
        if (array_key_exists('auth', $this->rules())) {
            foreach ($this->rules()['auth'] as $key => $value) {
                if (in_array($this->callerAction(), $value)) {
                    $roles[] = $key;
                }
            }
        }

        require $this->layout;
    }

    public function redirect($url=null)
    {
        return static::redirectTo($this->siteUrl($url));
    }

    public function siteUrl($url=null)
    {
        if (is_string($url)) {
            return static::url($url);
        } elseif (is_array($url)) {
            return static::url($this->viewDir() . ($url != null ? '/' : '') . $url[0]);
        }
    }

    /** 
    * Request get Http method.
    * @param string $value
    * @return [] or string
    */ 
    public function get($value='')
    {
        return static::$app->request->get($value);
    }

    /** 
    * Request post Http method.
    * @param string $value
    * @return [] or string
    */ 
    public function post($value='')
    {
        return static::$app->request->post($value);
    }
}
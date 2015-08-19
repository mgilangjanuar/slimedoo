<?php

use \App;

class BaseController extends App
{
    public $layout = 'app/views/layouts/main.php';

    public $errorLayout = 'app/views/layouts/main.php';

    public $publicFunction = 'action';

    public $defaultFunction = 'index';

    public $alert;

    public $title;

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
        $className = str_replace('Controller', '', $className);
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
        $validate = false;
        $roles = [];
        if (array_key_exists('auth', $this->rules())) {
            foreach ($this->rules()['auth'] as $key => $value) {
                if (in_array($this->callerAction(), $value)) {
                    $roles[] = $key;
                }
            }
        }

        if ($roles == null) {
            $validate = true;
        } elseif (App::$user->isSigned() && in_array(App::role(), $roles)) {
            $validate = true;
        } elseif (App::$user->isSigned() && in_array('@', $roles)) {
            $validate = true;
        } elseif (!App::$user->isSigned() && in_array('#', $roles)) {
            $validate = true;
        }

        $__content = 'app/views/' . $this->viewDir() . '/' . $__content . (strpos($__content, '.') ? '' : '.php');
        extract($data);
        if ($validate) {
            require $this->layout;
        } else {
            return $this->forbidden('You don\'t have access to this content');
        }
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

    public function alert()
    {
        if ($this->alert != null) {
            foreach ($this->alert as $key => $value) {
                return \helpers\BaseHtml::alert($key, $value);
            }
        }
    }

    public function forbidden($message)
    {
        $type = 'Forbidden (#403)';
        $__content = 'app/views/site/error.php';
        require $this->errorLayout;
    }

    public function notFound($message)
    {
        $type = 'Not Found (#404)';
        $__content = 'app/views/site/error.php';
        require $this->errorLayout;
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
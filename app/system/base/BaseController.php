<?php

use \App;
use \Assets;
use \helpers\Url;
use \helpers\BaseHtml;

class BaseController extends App
{
    public $assets;

    public $layout = 'app/views/layouts/main.php';

    public $errorLayout = 'app/views/layouts/main.php';

    public $publicFunction = 'action';

    public $defaultFunction = 'index';

    public $alert;

    public $title;

    public $breadcrumb;

    public function __construct()
    {
        $this->assets = new Assets;
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

    protected function callerAction()
    {
        if (strpos(debug_backtrace()[2]['function'], $this->publicFunction) === 0) {
            return lcfirst(substr(debug_backtrace()[2]['function'], strlen($this->publicFunction)));
        } else {
            return false;
        }
    }

    public function render($__content, $data=[])
    {
        if ($this->callerAction() === false) {
            extract($data);
            require 'app/views/' . $this->viewDir() . '/' . $__content . (strpos($__content, '.') ? '' : '.php');
        } else {
            $roles = [];
            if (array_key_exists('auth', $this->rules())) {
                foreach ($this->rules()['auth'] as $key => $value) {
                    if (in_array($this->callerAction(), $value)) {
                        $roles[] = $key;
                    }
                }
            }

            $validate = false;
            if ($roles == null) {
                $validate = true;
            } elseif (App::$user->isSigned() && in_array(App::role(), $roles)) {
                $validate = true;
            } elseif (App::$user->isSigned() && in_array('@', $roles)) {
                $validate = true;
            } elseif (!App::$user->isSigned() && in_array('#', $roles)) {
                $validate = true;
            }

            if ($validate) {
                $__content = 'app/views/' . $this->viewDir() . '/' . $__content . (strpos($__content, '.') ? '' : '.php');
                extract($data);

                ob_start();
                require $__content;
                ob_end_clean();
                require $this->layout;
            } else {
                return $this->forbidden('You don\'t have access to this content');
            }
        }
    }

    public function redirect($url=null)
    {
        return static::redirectTo(Url::autoDecide($url));
    }

    public function getAlert()
    {
        if ($this->alert != null) {
            foreach ($this->alert as $key => $value) {
                return BaseHtml::alert($key, $value);
            }
        }
    }

    public function getBreadcrumb($urlBase='')
    {
        if ($this->breadcrumb != null) {
            $result = '<ul class="breadcrumb"><li><a href=' . App::url($urlBase) . '>Home</a></li>';
            foreach ($this->breadcrumb as $value) {
                if (! array_key_exists('url', $value)) {
                    $result .= '<li class="active">' . $value['label'] . '</li>';
                } else {
                    $result .= '<li><a href="' . Url::autoDecide($value['url']) . '">' . $value['label'] . '</a></li>';
                }
            }
            $result .= '</ul>';
            return $result;
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

    public function style()
    {
        foreach ($this->assets->css() as $css) {
            echo $this->assets->cssLoad($css);
        }
        foreach ($this->assets->additionalCssFile as $file) {
            echo $this->assets->cssLoad($file);
        }
        foreach ($this->assets->additionalCss as $style) {
            echo "<style>";
            echo $style;
            echo "</style>";
        }
    }

    public function script()
    {
        foreach ($this->assets->js() as $js) {
            echo $this->assets->jsLoad($js);
        }
        foreach ($this->assets->additionalJsFile as $file) {
            echo $this->assets->jsLoad($file);
        }
        foreach ($this->assets->additionalJs as $script) {
            echo "<script>";
            echo $script;
            echo "</script>";
        }
    }

    public function registerCss($css)
    {
        $this->assets->addCss($css);
    }

    public function registerCssFile($css)
    {
        $this->assets->addCssFile($css);
    }

    public function registerJs($js)
    {
        $this->assets->addJs($js);
    }

    public function registerJsFile($js)
    {
        $this->assets->addJsFile($js);
    }

}
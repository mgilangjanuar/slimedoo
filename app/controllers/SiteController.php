<?php
namespace app\controllers;

use \App;
use \app\models\Book;
use \app\models\User;
use \ptejada\uFlex\Collection;

class SiteController extends \BaseController
{
    public function actionIndex()
    {
        return $this->render('index', [
            'hai' => 'Hello, World!'
        ]);
    }

    public function actionLogin()
    {
        $model = new User;
        if ($this->post()) {
            App::$user->login($this->post('Username'), $this->post('Password'), 0);
            if (App::$user->isSigned()) {
                return $this->redirect(['index']);
            } else {
                $this->alert = ['danger' => 'Username/Email or Password wrong.'];
            }
        }
        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionRegister()
    {
        $model = new User;
        if ($this->post()) {
            if ($model->validate() && $model->register($this->post())) {
                return $this->redirect(['login']);
            } elseif ($model->validate() && ! $model->register($this->post())) {
                $this->alert = ['danger' => App::$user->log->getErrors()[0]];
            }
        }
        return $this->render('register', [
            'model' => $model
        ]);
    }

    public function actionResetPassword()
    {
        
    }

    public function actionNewPassword($token)
    {
        
    }

    public function actionLogout()
    {
        App::$user->logout();
        return $this->redirect(['index']);
    }

    // This optional. Only override this method for custom routes.
    public function routes()
    {
        $results = parent::routes();
        $results['/'] = static::className() . ':actionIndex';
        return $results;
    }
}
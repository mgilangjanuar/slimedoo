<?php
namespace app\controllers;

use \app\models\Book;

class Site extends \BaseController
{
    public function actionIndex()
    {
        return $this->render('index', [
            'hai' => 'Hello, World!'
        ]);
    }

    public function actionLogin()
    {
        
    }

    public function actionRegister()
    {
        
    }

    public function actionResetPassword()
    {
        
    }

    public function actionNewPassword($token)
    {
        
    }

    // You can override this method for custom routes
    public function routes()
    {
        $results = parent::routes();
        $results['/'] = static::className() . ':actionIndex';
        return $results;
    }
}
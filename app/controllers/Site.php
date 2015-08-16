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

    // You can override this method for custom routes
    public function routes()
    {
        $results = parent::routes();
        $results['/'] = static::className() . ':actionIndex';
        return $results;
    }
}
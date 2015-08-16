<?php
namespace app\controllers;

use \app\models\Book;

class SiteController extends \BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    // You can override this method for custom routes
    public function routes()
    {
        $results = parent::routes();
        $results['/'] = static::className() . ':actionIndex';
        return $results;
    }
}
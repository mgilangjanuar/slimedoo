<?php
namespace app\controllers\admin;

use \App;
use \app\models\User;

class UserController extends \BaseController
{
    public $layout = 'app/views/layouts/admin.php';
    
    public function rules()
    {
        return [
            'auth' => [
                'theCreator' => ['index', 'view', 'update', 'delete'],
                'admin' => ['index', 'view', 'update', 'delete'],
            ]
        ];  
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'model' => User::find()
        ]); 
    }

    public function actionView($username)
    {
        return $this->render('view', [
            'model' => $this->findUser($username)
        ]);
    }

    public function actionUpdate($username)
    {
        $model = $this->findUser($username);
        if ($model->load(App::$app->request->post()) && $model->save()) {
            return $this->redirect(['view/' . $model->Username]);
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($username)
    {
        $this->findUser($username)->delete();
        return $this->redirect(['index']);
    }

    protected function findUser($username)
    {
        if (($model = User::find(['Username' => $username])->one()) != null) {
            return $model;
        }
        return $this->notFound('Page not found.');
    }
}
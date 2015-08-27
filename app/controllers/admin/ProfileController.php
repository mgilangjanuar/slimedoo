<?php 
namespace app\controllers\admin;

use \App;
use \app\models\User;

class ProfileController extends \BaseController
{
    public function rules()
    {
        return [
            'auth' => [
                '@' => ['index', 'change-password']
            ]
        ];  
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'model' => User::find(['ID' => App::$user->ID])
        ]);
    }

    public function actionChangePassword()
    {
        $model = new User;
        $model->scenario('new-password');
        if (App::$app->request->post()) {
            if ($model->newPassword(App::$app->request->post())) {
                if (App::$user->isSigned()) {
                    App::$user->logout();
                }
                return $this->redirect('site/login');
            } else {
                $this->alert = ['danger' => App::$user->log->getErrors()[0]];
            }
        }
        return $this->render('change-password', [
            'model' => $model
        ]);
    }

    public function routes()
    {
        $routes = parent::routes();
        $routes['/admin'] = static::className() . ':actionIndex';
        return $routes;
    }
}
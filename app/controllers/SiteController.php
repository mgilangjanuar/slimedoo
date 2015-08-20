<?php
namespace app\controllers;

use \App;
use \app\models\User;

class SiteController extends \BaseController
{
    public function rules()
    {
        return [
            'auth' => [
                '@' => ['logout'],
                '#' => ['login', 'reset-password', 'register', 'new-password'],
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'hai' => 'Hello, World!'
        ]);
    }

    public function actionAbout()
    {   
        return $this->render('about');
    }


    /**
    *
    * Please careful if you want to delete or modify methods below.
    *
    */

    public function actionLogin()
    {
        $model = new User;
        $model->scenario('login');
        if (App::$app->request->post() && $model->validate()) {
            App::$user->login(App::$app->request->post('Username'), App::$app->request->post('Password'), App::$app->request->post('rememberMe'));
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
        $model->scenario('register');
        if (App::$app->request->post() && $model->validate()) {
            if ($model->register(App::$app->request->post())) {
                return $this->redirect(['login']);
            } else {
                $this->alert = ['danger' => App::$user->log->getErrors()[0]];
            }
        }
        return $this->render('register', [
            'model' => $model
        ]);
    }

    public function actionResetPassword()
    {
        $model = new User;
        $model->scenario('reset-password');
        if (App::$app->request->post() && $model->validate()) {
            if ($model->resetPassword(App::$app->request->post())) {
                $model->Email = '';
                $this->alert = ['success' => 'Check your email in inbox/spam for confirmation link.'];
            } else {
                $this->alert = ['danger' => App::$user->log->getErrors()[0]];
            }
        }
        return $this->render('reset-password', [
            'model' => $model
        ]);
    }

    public function actionNewPassword()
    {
        if (! App::$app->request->get('c')) {
            return $this->forbidden('You don\'t have access to this content');
        }
        $model = new User;
        $model->scenario('new-password');
        if (App::$app->request->post() && $model->validate()) {
            if ($model->newPassword(App::$app->request->post(), App::$app->request->get('c'))) {
                if (App::$user->isSigned()) {
                    App::$user->logout();
                }
                return $this->redirect(['login']);
            } else {
                $this->alert = ['danger' => App::$user->log->getErrors()[0]];
            }
        }
        return $this->render('new-password', [
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        App::$user->logout();
        return $this->redirect(['login']);
    }

    // This optional. Only override this method for custom routes.
    public function routes()
    {
        $results = parent::routes();
        $results['/'] = static::className() . ':actionIndex';
        return $results;
    }
}
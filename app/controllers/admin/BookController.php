<?php 
namespace app\controllers\admin;

use \App;
use \app\models\Book;

class BookController extends \BaseController
{
    public $layout = 'app/views/layouts/admin.php';

    public function rules()
    {
        return [
            'auth' => [
                '@' => ['index', 'create', 'view', 'update', 'delete']
            ]
        ];  
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'model' => Book::find()
        ]);
    }

    public function actionCreate()
    {
        $model = new Book;
        if ($model->load(App::$app->request->post()) && $model->save()) {
            return $this->redirect(['view/' . $model->id]);
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findBook($id);
        if ($model->load(App::$app->request->post()) && $model->save()) {
            return $this->redirect(['view/' . $model->id]);
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findBook($id)
        ]);
    }

    public function actionDelete($id)
    {
        $this->findBook($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findBook($id)
    {
        if (($model = Book::find(['id' => $id])->one()) != null) {
            return $model;
        }
        return $this->notFound('Page not found.');
    }
}
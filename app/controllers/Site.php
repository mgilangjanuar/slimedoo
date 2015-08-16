<?php
namespace app\controllers;

use \app\models\Book;

class Site extends \BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreateBook()
    {
        // $book = Book::find()->where(['title' => 'Lalaa2']);
        $book = new Book;
        $book->title = 'Gilang Januae';
        $book->writer = 'Gilang Januae';
        var_dump($book->validate());
        var_dump($book->errors());
        var_dump($book->save());
    }

    public function actionList()
    {
        foreach (Book::find(['id[>]' => 3])->all() as $row) {
            // var_dump(Book::find()->all()); die();
            echo $row->id . ' ' . $row->title . ' ' . $row->writer . ' -' . $row->yeye . '<br>';
        }
    }

    public function actionDetail()
    {
        $query = Book::find(['id' => 1])->one();
        echo $query->id . ' ' . $query->title . ' ' . $query->writer . ' -' . $query->yeye . '<br>';
    }

    // You can override this method for custom routes
    public function routes()
    {
        $results = parent::routes();
        $results['/'] = static::className() . ':actionIndex';
        return $results;
    }
}
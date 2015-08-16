<?php 
namespace app\models;

class Book extends \BaseModel
{
    public function tableName()
    {
        return 'book';
    }

    public function fields()
    {
        return ['id', 'title', 'writer'];
    }

    public function rules()
    {
        return [
            'required' => ['title', 'writer'],
        ];
    }
}
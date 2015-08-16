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

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'writer' => 'Writer',
        ];
    }

    public function rules()
    {
        return [
            'required' => ['title', 'writer'],
        ];
    }

    public function ruleAlwaysFail()
    {
        return [
            'message' => 'Everything you do is wrong. You fail.',
            'function' => function($field, $value, array $params) {return true;},
        ];  
    }

    public function getLala()
    {
        return $this->title;
    }

    public function setLala($value)
    {
        $this->lala = $value;
    }

    public function getYeye()
    {
        return $this->lala;
    }
}
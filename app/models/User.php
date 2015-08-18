<?php
namespace app\models;

use \App;
use \ptejada\uFlex\Collection;

class User extends \BaseModel
{
    public function tableName()
    {
        return 'Users';
    }

    public function fields()
    {
        return ['ID', 'Username', 'Password', 'Email', 'Activated', 'Confirmation', 'RegDate', 'LastLogin', 'GroupID'];
    }

    public function rules()
    {
        return [
            [['Username', 'Password', 'Email'], 'required'],
            [['Email'], 'email'],
            [['RegDate', 'LastLogin', 'GroupID', 'Activated'], 'integer'],
            [['Activated'], 'lengthMax', 1],
            [['GroupID'], 'lengthMax', 2],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Username' => 'Username',
            'Password' => 'Password',
            'Email' => 'Email',
            'Activated' => 'Activated',
            'Confirmation' => 'Confirmation',
            'RegDate' => 'RegDate',
            'LastLogin' => 'LastLogin',
            'GroupID' => 'GroupID',
        ];
    }

    public function register($request, $activation=false)
    {
        if ($request != null) {
            if (User::find()->count() == null) {
                $request['GroupID'] = 0;
            } else {
                $request['GroupID'] = 2;
            }
            $input = new Collection($request);
            $input->filter('Username', 'Email', 'Password', 'GroupID');
            return App::$user->register($input, $activation);
        }
        return false;
    }

    public function activate($request)
    {
        if ($request != null) {
            $input = new Collection($request);
            $hash = $input->c;
            return App::$user->activate($hash);
        }
        return false;
    }

    public function resetPassword($request)
    {
        if ($request != null) {
            $input = new Collection($request);
            return App::$user->resetPassword($input->Email);
        }
        return false;
    }

    public function newPassword($request)
    {
        if ($request != null) {
            $input = new Collection($request);
            $hash = $input->c;
            if (!App::$user->isSigned() and $hash) {
                App::$user->newPassword($hash, [
                    'Password'  => $input->Password,
                ]);
                return 'login';
            } else {
                App::$user->update([
                    'Password'  => $input->Password,
                ]);
                return 'profile';
            }
        }
        return false;
    }
}
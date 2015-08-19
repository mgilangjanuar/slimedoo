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
        return ['Username', 'Password', 'Email', 'Password2', 'Email2', 'rememberMe'];
    }

    public function rules()
    {
        return [
            [['Email', 'Email2'], 'email'],
            [['RegDate', 'LastLogin', 'GroupID', 'Activated'], 'integer'],
            [['Activated'], 'lengthMax', 1],
            [['GroupID'], 'lengthMax', 2],
            [['Email2'], 'equals', 'Email'],
            [['Password2'], 'equals', 'Password'],
        ];
    }

    public function scenario($value)
    {
        if ($value == 'login') {
            $this->scenario = [['Username', 'Password'], 'required'];
        } elseif ($value == 'register') {
            $this->scenario = [['Username', 'Password', 'Email', 'Password2'], 'required'];
        } elseif ($value == 'reset-password') {
            $this->scenario = [['Email'], 'required'];
        } elseif ($value == 'new-password') {
            $this->scenario = [['Password', 'Password2'], 'required'];
        }
    }

    public function attributeLabels()
    {
        return [
            'Username' => 'Username',
            'Password' => 'Password',
            'Password2' => 'Password Confirmation',
            'Email' => 'Email',
            'Email2' => 'Email Confirmation',
            'rememberMe' => 'Remember Me',
        ];
    }

    public function register($request, $activation=false)
    {
        if ($request != null) {
            if (User::find()->count() == null) {
                $request['GroupID'] = 0;
            } else {
                $request['GroupID'] = 1;
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
            $user = App::$user->resetPassword($input->Email);
            if ($user != null) {
                App::$mail->addAddress($user->Email, $user->Username);
                App::$mail->Subject = 'Password Recovery';
                App::$mail->Body    = 'Your confirmation link: ' . App::url('site/new-password?c=' . $user->Confirmation);
                if (App::$mail->send()) {
                    return true;
                } else {
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . App::$mail->ErrorInfo;
                    die();
                }
            }
        }
        return false;
    }

    public function newPassword($request, $hash='')
    {
        if ($request != null) {
            $input = new Collection($request);
            if (!App::$user->isSigned() and $hash) {
                App::$user->newPassword($hash, [
                    'Password'  => $input->Password,
                    'Password2'  => $input->Password2,
                ]);
            } else {
                App::$user->update([
                    'Password'  => $input->Password,
                    'Password2'  => $input->Password2,
                ]);
            }
            return true;
        }
        return false;
    }
}
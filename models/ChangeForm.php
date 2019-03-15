<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ChangeForm extends Model
{


    public $oldpass;
    public $newpass;
    public $repeatnewpass;
    private $_user = false;



    /**
     * @return array the validation rules.
     */
    public function rules(){
        return [
            [['oldpass','newpass','repeatnewpass'],'required'],

            ['repeatnewpass','compare','compareAttribute'=>'newpass'],
            //['oldpass','validatePassword2'],
        ];
    }

    public function attributeLabels(){
        return [
            'oldpass'=>'старый пароль',
            'newpass'=>'новый пароль',
            'repeatnewpass'=>'повторно новый пароль',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */

    public function validatePassword2($attribute, $params)
    {



        if (!$this->hasErrors()) {
            $user =  User::findOne(['id' => Yii::$app->user->id]);

            if (!$user || !$user->validatePassword($this->oldpass)) {
                $this->addError($attribute, 'Неправильный логин или пароль.');
            }
        }
    }
    public function changePassword()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->setPassword($this->newpass);
            return $user->save();
        } else {
            return false;
        }
    }
    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername(Yii::$app->user->identity->username);
        }

        return $this->_user;
    }
}

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




    /**
     * @return array the validation rules.
     */
    public function rules(){
        return [
            [['newpass','repeatnewpass','oldpass'],'required'],

            ['repeatnewpass','compare','compareAttribute'=>'newpass'],
        ];
    }

    public function attributeLabels(){
        return [
            'oldpass'=>'старый пароль',
            'newpass'=>'новый пароль',
            'repeatnewpass'=>'проверка нового пароля',
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
      //  $user = User::findByUsername(Yii::$app->user->identity->username);
       // //$user=Yii::$app->user->identity;
       // if (!$user || !$user->validatePassword($this->oldpass)) {
            $this->addError('password', 'Неправильное имя пользователя или пароль.');
       // }

    }
    public function changePassword()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->setPassword($this->newPass);
            return $user->save();
        } else {
            return false;
        }
    }
    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */

}

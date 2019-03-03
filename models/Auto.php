<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auto".
 *
 * @property int $id
 * @property string $number
 * @property int $loginaddid
 * @property string $dateadd
 * @property string autotype
 * @property int $typeid
 * @property string $comments
 */
class Auto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loginaddid'], 'integer'],
            [['dateadd'], 'safe'],
            [['comments'], 'string'],
            [['number','type','typeauto','autotype'], 'string', 'max' => 255],
            [['type'],'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => '№',

            'loginaddid' => 'создатель ID',
            'username'=>'пользователь',
            'dateadd' => 'дата добавления',
            'dateaddtext' => 'дата добавления',
            'autotype'=>'тип авто',
            'type' => 'марка авто',
            'comments' => 'комментарий',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'loginaddid']);

    }
    public function GetUsername()
    {
        return $this->user->username;
    }
    public function getDateaddtext()
    {
            return date('Y.m.d H:i',$this->dateadd);
    }

}

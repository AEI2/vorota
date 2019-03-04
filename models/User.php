<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orgname','userchange'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['username'], 'required'],
            [[ 'status2'], 'integer'],
            [[ 'comment'], 'string'],
            [['username','password','email', 'orgname', 'contaktname', 'contakttel','orgname'], 'string', 'max' => 255],
            [['username'], 'unique'],



        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'=>'№',
            'username' => 'логин',

            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'email',
            'status' => 'права',
            'created_at' => 'дата создания',
            'updated_at' => 'изменено',
            'userchangename' =>'изменил(а)',
            'orgname' => 'фирма',
            'contaktname' => 'имя',
            'contakttel' => 'телефон',
            'status2' => 'права',
            'statusname' => 'права',
            'comment' => 'комментарий',
            'createtext'=>'Дата создания',
            'datechangetext'=>'изменено',


        ];
    }
    public function getStatusname()
    {
        $array=[
            '1'=>'охрана',
            '2'=>'фирма',
            '9'=>'админ',
            ];
        return $array[$this->status2];//$this->hasOne(Typedoc::className(), ['id' => 'typedoc_id']);
    }
    public function getUserchange2()
    {
        return $this->hasOne(User::className(),['id'=>'userchange']);

    }
    public function getDatechangetext()
    {
        return date('d-m-Y H:i',$this->updated_at);
    }
    public function getUserchangename()
    {
        return $this->userchange2->username;

    }
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function getCreatetext()
    {
        if (isset($this->created_at))
        {
             return date('d.m.Y H:i',$this->created_at);

        }

    }
    public function getUpdatetext()
    {
        if (isset($this->updated_at))
        {
            return date('d.m.Y H:i',$this->updated_at);

        }

    }

}
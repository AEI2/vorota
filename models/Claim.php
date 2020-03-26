<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
/**
 * This is the model class for table "claim".
 *
 * @property int $id
 * @property string $dateadd
 * * @property string $dateaddtext
 * @property int $loginadd
 * @property int $autoid
 * @property string $auton
 * @property string $datein
 * @property string $dateout
 * @property int $statusid
 * @property int $statusloginid
 * * @property int $typestatus
 * @property string $comments
 *@property string $orgid
 * *@property string $username
 */
class Claim extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $datedel;

    //public $dateaddtext;

    public static function tableName()
    {
        return 'claim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dateadd', 'datein', 'dateout','datechange','datedel','username','dateorin','id'], 'safe'],
            [['loginadd','orgid', 'autoid', 'statusid', 'statusloginid','typestatus','cancel'], 'integer'],
            ['typestatus','in', 'range' => [0,1,2,3,4,6]],
            [['dateorin'],'validateDate'],
            [['autotype','comments','orgname'], 'string', 'max' => 50],
            [['autotype','auton','orgname'], 'required'],
            //['orgid',  'compare', 'compareValue' => 2, 'operator' => '>=','message' => '{attribute} не может быть пустым'],
            //['auton', 'match', 'pattern' => '/^[А,В,Е,К,М,Н,О,Р,С,Т,У,Х][0-9]{3}[А,В,Е,К,М,Н,О,Р,С,Т,У,Х]{2}[0-9]{2,3}/','message' => '{attribute} может содержать только заглавные русские буквы(А,В,Е,К,М,Н,О,Р,С,Т,У,Х) и числа в следующем порядке А555АА555.'],
            [['auton'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'cancel'=>'отмена',
            'dateadd' => 'дата создания',
            'dateorin' => 'дата заявки',
            'orgid' => 'организация',
            'orgname' => 'фирма',
            'dateaddtext' => 'создано',
            //'loginadd' => 'Создатель ID',
            'username' => 'создал(а)',
            'autoid' => 'тип авто',
            'autotype' => 'тип авто',
            'auton' => 'номер авто',
            'orgnametext'=>'фирма',
            'dateorintext'=>'дата заезда',
            'dateintext' => 'заезд',
            'dateouttext' => 'выезд',
            'statusid' => 'статус ID',
            'typestatus' => 'источник',
            'typestatusname'=>'статус',
            'datechange'=>'изменено',
            'userlastchangename'=>'изменил(а)',
            'statusloginid' => 'пользователь/статус ID',
            'comments' => 'комментарий',
            'typestatusname2'=>'источник',
            'datechangetext' => 'изменено'
        ];
    }

    public function validateDate()
    {
        if ($this->dateorin <strtotime('d.m.Y')){
            $this->addError('dateorin', '"Дата не может быть меньше текущей"');

        }

    }
    public function getUserlastchange()
    {
        return $this->hasOne(User::className(),['id'=>'statusloginid']);

    }
    public function getOrgname2()
    {
        return $this->hasOne(User::className(),['id'=>'orgid']);
    }
    public function getOrgnametext()
    {
        return $this->orgname2->orgname;
    }
    public function getTypestatusname2()
    {
        $items = array(0=>'Телефон',1=>'устно',2=>'сайт',3=>'эл. почта',4=>'бумага',6=>'сайт');
        return $items[$this->typestatus];
    }
    public function GetUserlastchangename()
    {
        $items = [1=>'охрана',2=>'фирма'];
        if (isset($this->userlastchange->username))
        {
            //return Html::a($this->userlastchange->contaktname.' '.$this->userlastchange->orgname, ['user/view','id'=>$this->userlastchange->id]);
            return $this->userlastchange->username.'.'.$this->userlastchange->contaktname;
        }else {return '';};

    }
    public function GetTypestatusname()
    {
        $items = [0=>'ожидание',1=>'убыл',2=>'отменена','3'=>'прибыл'];
        //if (($this->datein>10)and ($this->statusid==0)) return 'прибыл';
        return $items[$this->statusid];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'loginadd']);

    }

    public function GetUsername()
    {
        $items = [1=>'охрана',2=>'фирма'];

//        return Html::a($this->user->username.' '.$items[$this->user->status2], ['user/view','id'=>$this->user->id]);
        return $this->user->username.'.'.$this->user->contaktname;
    }

    public function getAuto()
    {
        return $this->hasOne(Auto::className(),['id'=>'autoid']);
    }
    public function getAutotype()
    {
        return $this->auto->type;
    }

    public function getDateintext()
    {
        if (isset($this->datein))
        {
            if (date('N',$this->datein)==1) $d='пн';
            if (date('N',$this->datein)==2) $d='вт';
            if (date('N',$this->datein)==3) $d='ср';
            if (date('N',$this->datein)==4) $d='чт';
            if (date('N',$this->datein)==5) $d='пт';
            if (date('N',$this->datein)==6) $d='сб';
            if (date('N',$this->datein)==7) $d='вс';

            return $d.' '.date('d.m.Y',$this->datein).' '.date('H:i',$this->datein);

        }

    }
    public function getDateouttext()
    {
        if (isset($this->dateout))
        {
            if (date('N',$this->dateout)==1) $d='пн';
            if (date('N',$this->dateout)==2) $d='вт';
            if (date('N',$this->dateout)==3) $d='ср';
            if (date('N',$this->dateout)==4) $d='чт';
            if (date('N',$this->dateout)==5) $d='пт';
            if (date('N',$this->dateout)==6) $d='сб';
            if (date('N',$this->dateout)==7) $d='вс';

            return $d.' '.date('d.m.Y',$this->dateout).' '.date('H:i',$this->dateout);
        }

    }
    public function getDateaddtext()
    {
        if (isset($this->dateadd))
        {
            if (date('N',$this->dateadd)==1) $d='пн';
            if (date('N',$this->dateadd)==2) $d='вт';
            if (date('N',$this->dateadd)==3) $d='ср';
            if (date('N',$this->dateadd)==4) $d='чт';
            if (date('N',$this->dateadd)==5) $d='пт';
            if (date('N',$this->dateadd)==6) $d='сб';
            if (date('N',$this->dateadd)==7) $d='вс';

            return $d.' '.date('d.m.Y',$this->dateadd).' '.date('H:i',$this->dateadd);
        }

    }
    public function getDatechangetext()
    {
        if (isset($this->datechange))
        {
            if (date('N',$this->datechange)==1) $d='пн';
            if (date('N',$this->datechange)==2) $d='вт';
            if (date('N',$this->datechange)==3) $d='ср';
            if (date('N',$this->datechange)==4) $d='чт';
            if (date('N',$this->datechange)==5) $d='пт';
            if (date('N',$this->datechange)==6) $d='сб';
            if (date('N',$this->datechange)==7) $d='вс';

            return $d.' '.date('d.m.Y',$this->datechange).' '.date('H:i',$this->datechange);
        }

    }
    public function getDateorintext()
    {
        if (date('N',$this->dateorin)==1) $d='пн';
        if (date('N',$this->dateorin)==2) $d='вт';
        if (date('N',$this->dateorin)==3) $d='ср';
        if (date('N',$this->dateorin)==4) $d='чт';
        if (date('N',$this->dateorin)==5) $d='пт';
        if (date('N',$this->dateorin)==6) $d='сб';
        if (date('N',$this->dateorin)==7) $d='вс';

        return $d.' '.date('d.m.Y',$this->dateorin);

    }
}

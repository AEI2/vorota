<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Claim;

/**
 * ClaimSearch represents the model behind the search form of `app\models\Claim`.
 */
class ClaimSearch extends Claim
{
    /**
     * {@inheritdoc}
     */
    public $dateaddtext;
    public $orgnametext;
    public $username;
    public $typestatusname2;
    public $typestatusname;
    public $dateorintext;
    public $userlastchangename;
    public $datechangetext;
    function dateadd($d)
    {
        $date2=explode('.',$d);
        if (count($date2)==1)$full=$d.'.'.date('m.Y');
        if (count($date2)==2)$full=$date2[0].'.'.$date2[1].'.'.date(Y);
        if (count($date2)==3)$full=$d;
        //echo $full;
        //print_r($date2);
        return $full;
    }
    public function rules()
    {
        return [
            [['id', 'loginadd', 'autoid', 'statusid', 'statusloginid','cancel',], 'integer'],
            [['userlastchangename','datechangetext','dateadd','datein', 'dateout', 'comments','auton','dateaddtext','orgnametext','username','typestatusname2','autotype','auton','orgid','dateorintext','typestatusname'], 'safe'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

        $query = Claim::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'dateaddtext' => [
                    'asc' => ['dateadd' => SORT_ASC],
                    'desc' => ['dateadd' => SORT_DESC],
                    'label' => 'org name',
                    'default' => SORT_ASC
                ],
                'dateorintext' => [
                    'asc' => ['dateorin' => SORT_ASC],
                    'desc' => ['dateorin' => SORT_DESC],
                    'label' => 'org name',
                    'default' => SORT_ASC
                ],
                'username' => [
                    'asc' => ['loginadd' => SORT_ASC],
                    'desc' => ['loginadd' => SORT_DESC],
                    'label' => 'org name',
                    'default' => SORT_ASC
                ],

                'typestatusname2' => [
                    'asc' => ['typestatus' => SORT_ASC],
                    'desc' => ['typestatus' => SORT_DESC],
                    'label' => 'org name',
                    'default' => SORT_ASC
                ],
                'typestatusname' => [
                    'asc' => ['statusid' => SORT_ASC],
                    'desc' => ['statusid' => SORT_DESC],
                    'label' => 'org name',
                    'default' => SORT_ASC
                ],

                'orgnametext' => [
                    'asc' => ['orgid' => SORT_ASC],
                    'desc' => ['orgid' => SORT_DESC],
                    'label' => 'org name',
                    'default' => SORT_ASC
                ],
                'datechangetext' => [
                    'asc' => ['datechange' => SORT_ASC],
                    'desc' => ['datechange' => SORT_DESC],
                    'label' => 'org name',
                    'default' => SORT_ASC
                ],
                'userlastchangename' => [
                    'asc' => ['statusloginid' => SORT_ASC],
                    'desc' => ['statusloginid' => SORT_DESC],
                    'label' => 'org name',
                    'default' => SORT_ASC
                ],
                'autotype',
                'auton',

            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');

            $query->joinWith(['orgname2']);
            return $dataProvider;
        }
        //$this->addCondition($query, 'orgid');
        // grid filtering conditions
        $query->andFilterWhere([
            'claim.id' => $this->id,
            'orgid' => $this->orgid,
            'loginadd' => $this->username,
            'autoid' => $this->autoid,
          //  'datein' => $this->datein,
          //  'dateout' => $this->dateout,
            'statusid' => $this->statusid,
            'statusloginid' => $this->statusloginid,
          //  'cancel' => $this->cancel,
            'typestatus' => $this->typestatusname2,
            'statusid' => $this->typestatusname,

            'statusloginid'=>$this->userlastchangename,
            ]);
        if  ($this->dateorintext=='')$this->dateorintext='='.date('d.m.Y');

        if (strlen($this->dateorintext)>1)
        {
            if (substr($this->dateorintext,0,1)=='>') $query->andFilterWhere(['>', 'dateorin', strtotime($this->dateadd(substr($this->dateorintext,1)))]);
            if (substr($this->dateorintext,0,1)=='<') $query->andFilterWhere(['<', 'dateorin', strtotime($this->dateadd(substr($this->dateorintext,1)))]);
            if (substr($this->dateorintext,0,1)=='=') $query->andFilterWhere(['=', 'dateorin', strtotime($this->dateadd(substr($this->dateorintext,1)))]);
        }

        if (strlen($this->dateorintext)>1)
        {
            if (substr($this->datechangetext,0,1)=='>') $query->andFilterWhere(['>', 'datechange', strtotime($this->dateadd(substr($this->datechangetext,1)))]);
            if (substr($this->datechangetext,0,1)=='<') $query->andFilterWhere(['<', 'datechange', strtotime($this->dateadd(substr($this->datechangetext,1)))]);
            if (substr($this->datechangetext,0,1)=='=') $query->andFilterWhere(['=', 'datechange', strtotime($this->dateadd(substr($this->datechangetext,1)))]);
        }



        $query->andFilterWhere(['like', 'comments', $this->comments]);
        $query->andFilterWhere(['like', 'autotype', $this->autotype]);

        $query->andFilterWhere(['like', 'auton', $this->auton]);
        if (substr($this->dateaddtext,0,1)=='>') $query->andFilterWhere(['>', 'dateadd', strtotime($this->dateadd(substr($this->dateaddtext,1)))]);
        if (substr($this->dateaddtext,0,1)=='<') $query->andFilterWhere(['<', 'dateadd', strtotime($this->dateadd(substr($this->dateaddtext,1)))]);
        if (substr($this->dateaddtext,0,1)=='=') $query->andFilterWhere(['=', 'dateadd', strtotime($this->dateadd(substr($this->dateaddtext,1)))]);
        $query->joinWith(['orgname2' => function ($q) {
            $q->where('user.orgname LIKE "%' . $this->orgnametext . '%"');
        }]);
     /*  $query->joinWith(['user' => function ($q) {
            $q->where('user2.username LIKE "%' . $this->username . '%"');
        }]);*/

        return $dataProvider;
    }
}

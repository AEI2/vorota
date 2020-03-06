<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ClaimSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="claim-index">


    <!--<h1 style="<?=$color?>"><?= Html::encode($this->title) ?></h1>-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <?= Html::a('создать заявку', ['create'], ['class' => 'btn btn-success pull-right']) ?>

<!--     <?php// $form = ActiveForm::begin(); ?>

     <?php //echo $form->field($model, 'datedel')->widget(\yii\widgets\MaskedInput::className(), [        'mask' => '01.01.2019',    ]); ?>
     <?php  //echo Html::submitButton('Удалить до даты', ['class' => 'btn btn-success']) ?>
     <?php //ActiveForm::end(); ?>-->


    <?php

    ?>
    <?php
   // $filterchange = ArrayHelper::getColumn(\app\models\Claim::find()->select('statusloginid')->groupBy(['statusloginid'])->all(),'statusloginid');
   // $filteradd = ArrayHelper::getColumn(\app\models\Claim::find()->select('loginadd')->groupBy(['loginadd'])->all(),'loginadd');

  //  $userchange=ArrayHelper::map(\app\models\User::find()->where(['in','id',$filterchange])->all(),'id','username');
  //  $useradd=ArrayHelper::map(\app\models\User::find()->where(['in','id',$filteradd])->all(),'id','username');


    $listdata=ArrayHelper::getColumn(\app\models\Claim::find()->select(['auton'])->groupBy(['auton'])->all(),'auton');
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'rowOptions' => function($model, $key, $index, $column){
            if ($model->statusid==2)
            {
                return ['class' => 'warning'];
            }
            if($index % 2 == 0){
                return ['class' => 'info'];
                }


        },
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            'dateorintext',
            [
                'attribute' =>'typestatusname2',
                'filter'    =>
                        [ 0=>'телефон',1=>'устно',3=>'эл. почта',4=>'бумага',6=>'сайт' ],



            ],
            [

                'attribute' =>'orgnametext',
                'visible' => $visible
                            ,
                ],
            [
                'attribute' =>'autotype',

            ],

            [
                'attribute' =>'auton',
                'filter' => AutoComplete::widget([
                    'model' => $searchModel,
                    'attribute' => 'auton',
                    'clientOptions' => [
                        'source' => $listdata,
                        'autoFill' => true,
                        'minLength' => 1
                    ],
                    'options' => [
                        'class' => 'form-control'
                    ]
                ]),

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'заезд',
                'template' => '{status}',
                'visible' => $visible,
                'buttons' => [
                    'status' => function ($url,$model) {
                        if ($model->statusid<>2)
                        {
                            if (Yii::$app->user->identity->status2 <> '2') {
                                if (isset($model->datein)) {
                                    return $model->dateintext;

                                } else {
                                    if (($model->cancel == 1)or(date('Y-m-d',$model->dateorin)>date('Y-m-d'))) {
                                        return '';
                                    } else {
                                        return Html::a(
                                            '<span class="btn btn-warning">прибыл</span>',
                                            $url);
                                    }

                                }

                            }
                        }
                    }

                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'выезд',
                'template' => '{status}',
                'visible' => $visible,
                'buttons' => [
                    'status' => function ($url,$model) {
                        if ($model->statusid<>2) {
                            if (Yii::$app->user->identity->status2 <> '2') {
                                if ((isset($model->datein)) and (isset($model->dateout))) {
                                    return $model->dateouttext;
                                }
                                if ((isset($model->datein)) and (!isset($model->dateout))) {
                                    return Html::a(
                                        '<span class="btn btn-success">&nbsp;у б ы л </span>',
                                        $url);
                                }
                            }
                        }
                    },

                ],
            ],




            'comments:ntext',
            [
                'class' => 'yii\grid\ActionColumn',
                'visible' => $visible,
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url,$model) {
                        if ($model->cancel <> 1) {
                            if ($model->typestatusname=='ожидание')
                            {
                                return Html::a(

                                    '<span data-title="изменить" class="glyphicon glyphicon-pencil hover"></span>',
                                    $url);
                            }
                            }

                    }

                ],
            ],
            ['attribute'=>'typestatusname',
           'filter'    =>
                        [0=>'ожидание',1=>'убыл',2=>'отменена','3'=>'прибыл'],
                ],





            [
                'class' => 'yii\grid\ActionColumn',
                //'header'=>'отмена',

                'template' => '{cancel}',
                'buttons' => [
                    'cancel' => function ($url,$model) {

                        if ((!isset($model->datein))) {
                            if ($model->statusid<>2){
                                return Html::a(

                                    '<span data-title="отменить" class="glyphicon glyphicon-remove hover"></span>',
                                    $url);
                            }
                            else {
                                return Html::a(

                                    '<span data-title="восстановить" class="glyphicon glyphicon-arrow-up hover" ></span>',
                                    $url);



                            }
                        }



                    },
                    'link' => function ($url,$model,$key) {
                        return Html::a('Действие', $url);
                    },
                ],
            ],




            [
                'attribute' =>'dateaddtext',

            ],
            [
                'attribute' => 'username',
                //'filter'=>$useradd,
                'format' => 'raw',

            ],

            'datechangetext'
            ,
            [
                'attribute' => 'userlastchangename',
                //'format' => 'raw',
                 //   'filter'=>$userchange,


            ],





        ],
    ]); ?>
</div>

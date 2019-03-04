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

    <?php
    if (Yii::$app->user->identity->status2== 2) $color='color:rgb(0,160,128)';
    if (Yii::$app->user->identity->status2==1) $color='color:rgb(0,128,160)';
    if (Yii::$app->user->identity->status2==0) $color='color:rgb(128,64,96)';

    ?>
    <!--<h1 style="<?=$color?>"><?= Html::encode($this->title) ?></h1>-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


     <?php $form2 = ActiveForm::begin(); ?>
    <div class="col-xs-2">
     <?php echo $form2->field($model2,'datedel')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '99.99.9999']); ?>
    </div>
    <div class="col-xs-2">
     <?php echo Html::submitButton('Удалить до даты', ['class' => 'btn btn-success']) ?>
    </div>
     <?php ActiveForm::end(); ?>


    <?php

    ?>
    <?php
    $listdata=ArrayHelper::getColumn(\app\models\Claim::find()->select(['auton'])->groupBy(['auton'])->all(),'auton');
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model, $key, $index, $column){

                return ['class' => 'warning'];



        },
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            'dateorintext',
            [
                'attribute' =>'typestatusname2',
                'filter'    => [ 0=>'Телефон',1=>'устно',2=>'сайт',3=>'эл. почта',4=>'бумага',6=>'сайт' ],

            ],
            'orgnametext',
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
                'header'=>' з а е з д ',
                'template' => '{status}',
                'visible' => $visible,
                'buttons' => [
                    'status' => function ($url,$model) {

                                    return $model->dateintext;



                    }

                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>' в ы е з д ',
                'template' => '{status}',
                'visible' => $visible,
                'buttons' => [
                    'status' => function ($url,$model) {

                                    return $model->dateouttext;

                    },

                ],
            ],




            'comments:ntext',

            'typestatusname',

            [
                'class' => 'yii\grid\ActionColumn',
               // 'header'=>'восстановить',
                'template' => '{vosst}',
                'buttons' => [
                    'vosst' => function ($url,$model) {


                            return Html::a(

                                '<span class="glyphicon glyphicon-arrow-up"></span>',
                                $url);





                    },
                    'link' => function ($url,$model,$key) {
                        return Html::a('Действие', $url);
                    },
                ],
            ],



        ],
    ]); ?>
</div>

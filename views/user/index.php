<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('добавить пользователя', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model, $key, $index, $column){
            if ($model->status==0)
            {
                return ['class' => 'warning'];
            }

        },
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
'id',
            'username',
            'email:email',
            'orgname',
            'contaktname',
            'contakttel',
            'statusname',

            'datechangetext',
            'userchangename',
            'comment',
            /*[
                'class' => \yiister\grid\widgets\InputColumn::className(),
                'attribute' => 'title',
                'headerOptions' => ['width' => '280'],
                'updateAction' => '/index.php?r=ads%2Fcolumn-update',
            ],*/
            ['class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '80'],
                'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{cancel}',
            'buttons' => [
                    'update' => function ($url,$model) {

                        if ($model->status<>0) {
                            return Html::a(

                                '<span class="glyphicon glyphicon-pencil"></span>',
                                $url);
                        }

                },
                'cancel' => function ($url,$model) {

                        if ($model->status==0)
                        {
                        return Html::a(

                            '<span class="glyphicon glyphicon-arrow-up"></span>',
                            $url);
                        }else{
                        return Html::a(

                            '<span class="glyphicon glyphicon-remove"></span>',
                            $url);
                    }
                }
            ],
        ],],
    ]); ?>
</div>

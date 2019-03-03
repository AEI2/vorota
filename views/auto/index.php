<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AutoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Автомобили';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить транспорт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'dateaddtext',
            'type',
            'typeauto',
            'comments:ntext',

            ['class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '80'],
                'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}'],
        ],

    ]); ?>
</div>

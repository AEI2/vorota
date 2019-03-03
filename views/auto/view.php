<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Auto */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Автомобили', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['Обновить', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['удалить', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'number',
            'loginaddid',
            'dateadd',
            'type',
            'comments:ntext',
        ],
    ]) ?>

</div>

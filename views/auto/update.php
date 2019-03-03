<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Auto */

$this->title = 'Обновление автомобиля: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Автомобили', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Оновить';
?>
<div class="auto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

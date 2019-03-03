<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Auto */

$this->title = 'Новое авто';
$this->params['breadcrumbs'][] = ['label' => 'Автомобили', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="auto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

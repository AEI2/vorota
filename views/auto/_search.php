<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AutoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'loginaddid') ?>

    <?= $form->field($model, 'dateadd') ?>

    <?= $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'comments') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

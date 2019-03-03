<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClaimSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="claim-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'dateadd') ?>

    <?= $form->field($model, 'loginadd') ?>

    <?= $form->field($model, 'autoid') ?>

    <?= $form->field($model, 'datein') ?>

    <?php // echo $form->field($model, 'dateout') ?>

    <?php // echo $form->field($model, 'statusid') ?>

    <?php // echo $form->field($model, 'statusloginid') ?>

    <?php // echo $form->field($model, 'comments') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

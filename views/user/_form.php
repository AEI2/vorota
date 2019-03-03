<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    if (Yii::$app->user->identity->id==1)
    {
        $items = [9=>'администратор',1=>'охрана',2=>'фирма'];
    }
    else{
        $items = [8=>'',1=>'охрана',2=>'фирма'];
    }
    $params = [
        'prompt' => 'Укажите тип документа'
    ];
    echo $form->field($model, 'status2')->dropDownList($items);
    ?>
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'password')->textInput()->label('пароль') ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'orgname')->textInput()->hint('Заполняется только для фирм')?>
    <?= $form->field($model, 'contaktname')->textInput() ?>
    <?= $form->field($model, 'contakttel')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '+7 (999) 999 99 99',
    ]); ?>


    <?php


    ?>
    <?= $form->field($model, 'comment')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('сохранить и закрыть', ['class' => 'btn btn-success']) ?>
        <?= Html::a('закрыть', ['user/index'], ['class' => 'btn btn-warning ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\widgets\ActiveForm;
use app\models\Auto;

/* @var $this yii\web\View */
/* @var $model app\models\Auto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auto-form">

    <?php $form = ActiveForm::begin(); ?>



    <?
    //фомируем список
    $listdata=ArrayHelper::getColumn(Auto::find()->select(['type'])->all(),'type');

    ?>

    <?= $form->field($model, 'type')->widget(
        AutoComplete::className(), [
        'clientOptions' => [
            'source' => $listdata,

        ],
        'options'=>[
            'class'=>'form-control'
        ]
    ]); ?>
    <?= $form->field($model, 'typeauto')->textInput() ?>


    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'изменение пароля';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    if (isset($error))
    {
        echo "<h1 style=\"color:rgb(255,0,0)\">".$error."</h1>";
    }
    ?>


    <?php $form = ActiveForm::begin([
        'id' => 'change-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>




    <?= $form->field($model, 'oldpass')->passwordInput()->label('старый пароль') ?>

    <?= $form->field($model, 'newpass')->passwordInput()->label('новый пароль') ?>

    <?= $form->field($model, 'repeatnewpass')->passwordInput()->label('Повторно новый пароль') ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>

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



    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>


    <?php if(isset($error)) echo  '<font color="red">'.$error.'</font>'?>
    <?= $form->field($model, 'oldpass')->passwordInput()->label('старый пароль') ?>

    <?= $form->field($model, 'newpass')->passwordInput()->label('укажите <font color="red">новый пароль</font>') ?>

    <?= $form->field($model, 'repeatnewpass')->passwordInput()->label('повторно <font color="red">новый пароль</font>') ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                <?= Html::a('закрыть', ['user/index'], ['class' => 'btn btn-warning ']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>

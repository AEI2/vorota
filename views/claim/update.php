<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Claim */

$this->title = 'обновить заявку';

$this->params['breadcrumbs'][] = ['label' => 'заявки', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'обновить';
//$model->
?>

<div class="claim-update">
<h1>
    <?php
    echo date('d.m.Y H:i').' '.Yii::$app->user->identity->username.'.'.Yii::$app->user->identity->orgname;
    ?>
<br>
    <?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

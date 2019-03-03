<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Claim */

$this->title = 'новая заявка';
$this->params['breadcrumbs'][] = ['label' => 'пропуска', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="claim-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

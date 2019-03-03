<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Auto;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\bootstrap4\Modal;

use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Claim */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="claim-form">

    <?php $form = ActiveForm::begin(); ?>
    <table width="200px">
        <tr><td>
    <?php
    if (Yii::$app->user->identity->status2=='2') {
        echo $form->field($model, 'typestatus')->hiddenInput(['value'=>'6'])->label(false);
        echo $form->field($model, 'orgid')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false);

    }else{

        // формируем массив, с ключем равным полю 'id' и значением равным полю 'name'
        $items = array(5=>'',3=>'эл. почта',4=>'бумага',0=>'телефон',1=>'устно');

        echo $form->field($model, 'typestatus')->dropDownList($items)->label('выберите <b>источник</b>');
        $items = ArrayHelper::map(\app\models\User::find()->where(['=','status2','2'])->all(),'id','orgname');
        //array_unshift($items, '');
        $items['1']='';
        ksort($items);
        echo $form->field($model, 'orgid')->dropDownList($items);
    }
    echo '<label>дата</label>';

    if ($model->dateorin>1){$date=date('d.m.Y',$model->dateorin);}else{$date=date('d.m.Y', strtotime('+1 days'));}

    echo $form->field($model, 'dateorin')->widget(DatePicker::class, [
            //'language' => 'ru',

            'options' => [
                //'placeholder' => Yii::$app->formatter->asDate($model->dateorin),
                 'value' => $date,
             //   'autocomplete'=>'off'
            ],
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pluginOptions' => [
                'orientation' => 'bottom auto',
                 'format' => 'dd.mm.yyyy',
                'autoclose' => true,
                'todayHighlight' => true
        ]
            ])->label(false);


    ?>
            </td></tr><tr><td>
    <?php
    $listdata=ArrayHelper::getColumn(\app\models\Claim::find()->select(['autotype'])->groupBy(['autotype'])->all(),'autotype');

    echo $form->field($model, 'autotype')->widget(
        AutoComplete::className(), [
        'clientOptions' => [
            'source' => $listdata,

        ],
        'options'=>[
            'class'=>'form-control'
        ]
    ]);


    /*$auto = Auto::find()->all();
    // формируем массив, с ключем равным полю 'id' и значением равным полю 'name'
    $items = ArrayHelper::map($auto,'id','type');
    $params = [
        'prompt' => 'Выберите тип авто'
    ];
    echo $form->field($model, 'autoid')->dropDownList($items,$params);*/
    ?>
            </td></tr><tr><td>


    <?= $form->field($model, 'auton')->textInput()?>
            </td></tr><tr><td>
    <?= $form->field($model, 'comments')->textInput() ?>
                <?=$form->field($model, 'datechange')->hiddenInput(['value'=>time()])->label(false);?>
        </tr></td></table>
    <div class="form-group">
        <?= Html::submitButton('сохранить и закрыть', ['class' => 'btn btn-success']) ?>
        <?= Html::a('закрыть', ['claim/index'], ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

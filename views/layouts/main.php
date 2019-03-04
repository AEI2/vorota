<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);

    if (Yii::$app->user->isGuest){

            $items[]=['label' => 'Войти', 'url' => ['/site/login']];
    } else {
        //$items[]=['label' => 'База авто', 'url' => ['/auto/index']];

        if (Yii::$app->user->identity->status2=='9')
        {
            $items[]=['label' => 'Заявки', 'url' => ['/claim/index']];
            $items[]=['label' => 'Заявки удаленные', 'url' => ['/claim/indexdel']];
            $items[]=['label' => 'Пользователи', 'url' => ['/user/index']];
        }
        $items[]=['label' => 'Изменить пароль', 'url' => ['/site/change']];

      //  $items[]=['label' => 'Заявки', 'url' => ['/claim/index']];
        //$items[]=['label' => 'About', 'url' => ['/site/about']];
        $items[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' =>$items,
    ]);
    NavBar::end();

    //print_r(Yii::$app->user->identity->status2);
    ?>

    <div class="container slim">
        <?/*= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) */?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

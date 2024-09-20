<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Link $model */

$this->title = 'Новая ссылка';
$this->params['breadcrumbs'][] = ['label' => 'Ссылки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

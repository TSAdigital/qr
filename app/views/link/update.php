<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Link $model */

$this->title = 'Редактирование ссылки: ' . preg_replace('/^(?:https?:\/\/)?([^\/]+).*$/', '$1', $model->link);
$this->params['breadcrumbs'][] = ['label' => 'Ссылки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => preg_replace('/^(?:https?:\/\/)?([^\/]+).*$/', '$1', $model->link), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>

<div class="link-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

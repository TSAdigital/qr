<?php

use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Link $model */
/** @var object $stats */
/** @var object $pagination */
/** @var integer $count */

$this->title = preg_replace('/^(?:https?:\/\/)?([^\/]+).*$/', '$1', $model->link);
$this->params['breadcrumbs'][] = ['label' => 'Ссылки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$i = $pagination->offset + 1;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
            'method' => 'post',
        ],
    ]) ?>
</p>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="base-tab" data-bs-toggle="tab" data-bs-target="#base-tab-pane" type="button" role="tab" aria-controls="base-tab-pane" aria-selected="true">Основное</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats-tab-pane" type="button" role="tab" aria-controls="stats-tab-pane" aria-selected="false">Статистика <sup><span class="badge bg-danger"><?= $count ?></span></sup></button>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="base-tab-pane" role="tabpanel" aria-labelledby="base-tab" tabindex="0">

        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-striped table-bordered mt-1'],
            'attributes' => [
                [
                    'attribute' => 'link',
                    'format' => 'url',
                    'captionOptions' => ['width' => '200px'],
                ],
                [
                    'attribute' => 'short_link',
                    'format' => 'raw',
                    'value' =>  Html::a(Url::home(true) . $model->short_link, ['site/get-link', 'id' => $model->short_link], ['id' => 'short-link', 'target' => '_blank']),
                ],
                [
                    'attribute' => 'qr_code',
                    'format' => 'raw',
                    'value' => '<span id="qr-code"></span>',
                ],
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>

    </div>
    <div class="tab-pane fade" id="stats-tab-pane" role="tabpanel" aria-labelledby="stats-tab" tabindex="0">

        <?php if ($stats) : ?>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col" style="min-width: 50px; text-align: center">#</th>
                    <th scope="col" style="width: 60%">IP адрес</th>
                    <th scope="col" style="width: 40%; text-align: center">Дата</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($stats as $stat): ?>
                    <tr>
                        <th scope="row" style="text-align: center"><?= $i++ ?></th>
                        <td><?= Html::encode($stat->ip_address) ?></td>
                        <td style="min-width: 50px; text-align: center"><?= Yii::$app->formatter->asDatetime($stat->created_at)?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>По этой ссылке еще не переходили.</p>
        <?php endif; ?>

        <?= LinkPager::widget([
            'pagination' => $pagination,
        ]); ?>

    </div>
</div>

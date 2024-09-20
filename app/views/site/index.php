<?php

/** @var yii\web\View $this */
/** @var app\models\Link $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Создать QR код без смс и регистраций';
?>

<div class="m-auto col-12 col-md-8 col-lg-6">
    <?php $form = ActiveForm::begin(['id' => 'qr-form', 'action' => ['site/index'], 'method' => 'post', 'options' => ['autocomplete' => 'off']]); ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton('Генерировать', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="text-center">
        <div id="qr-code-index"></div>
        <div id="link-index"></div>
    </div
</div>

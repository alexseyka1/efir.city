<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SeoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'rus_url') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'meta') ?>

    <?php // echo $form->field($model, 'title_text') ?>

    <?php // echo $form->field($model, 'html_1_header') ?>

    <?php // echo $form->field($model, 'html_1_text') ?>

    <?php // echo $form->field($model, 'html_2_header') ?>

    <?php // echo $form->field($model, 'html_2_text') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

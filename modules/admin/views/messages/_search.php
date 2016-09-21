<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\MessagesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="messages-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'post_datetime') ?>

    <?= $form->field($model, 'author_name') ?>

    <?= $form->field($model, 'author_uid') ?>

    <?= $form->field($model, 'message_to') ?>

    <?php // echo $form->field($model, 'message_text') ?>

    <?php // echo $form->field($model, 'city_id') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <?php // echo $form->field($model, 'pay_phone') ?>

    <?php // echo $form->field($model, 'connect_phone') ?>

    <?php // echo $form->field($model, 'is_paid') ?>

    <?php // echo $form->field($model, 'is_published') ?>

    <?php // echo $form->field($model, 'is_sent_sms') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

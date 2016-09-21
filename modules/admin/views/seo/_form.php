<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Seo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rus_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'meta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'title_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'html_1_header')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'html_1_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'html_2_header')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'html_2_text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

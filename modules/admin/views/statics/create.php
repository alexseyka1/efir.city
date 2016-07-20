<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Statics */

$this->title = 'Create Statics';
$this->params['breadcrumbs'][] = ['label' => 'Statics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statics-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

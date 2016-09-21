<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\SeoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ЧПУ и URL для SEO';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать SEO-URL', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
            /*'filterModel' => $searchModel,*/
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'url:url',
            'rus_url:url',
            /*'title:ntext',
            'meta:ntext',
             'title_text:ntext',
             'html_1_header',
             'html_1_text:ntext',
             'html_2_header',
             'html_2_text:ntext',*/

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

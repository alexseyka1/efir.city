<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Редактирование городов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

    <h1 style="display: inline-block;"><?= Html::encode($this->title) ?></h1> 
    <?= Html::a('<i class="add icon"></i> Добавить город', ['create'], ['class' => 'ui button positive right floated']) ?>
    
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'ui violet table'
        ],
        'layout'=>"{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'city_id',
            'country_id',
            'region_id',
            'name',
            //'active',
            [
                'attribute'=>'active',
                'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
                'content'=>function($data){
                    if($data->active == 1){
                        return '<div class="ui toggle green checkbox checked"><input type="checkbox" checked> <label></label></div>';
                    }else{
                        return '<div class="ui toggle green checkbox"><input type="checkbox"> <label></label></div>';
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

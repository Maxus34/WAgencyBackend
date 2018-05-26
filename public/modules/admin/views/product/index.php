<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Продукты';
$this->params['breadcrumbs'][] = ['label' => 'Админ', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать продукт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '30']
            ],
            'name',
            'price',
            [
                'attribute' => 'type',
                'value' => function ($data) {
                    return $data->getTypeLabel();
                }
            ],
            [
                'attribute' => 'category',
                'value' =>  function($data){
                    return $data->category->parent->name . ' > ' . $data->category->name;
                },
            ],
            [
                'label' => 'Изображение',
                'value' => function ($data) {
                    return Html::img($data->getMainImage()->getUrl([50, 50]), ['height' => 50, 'width' => 50]);
                },
                'format' => 'html'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Действия',
                'headerOptions' => ['width' => '70'],
            ],
        ],
    ]); ?>
</div>

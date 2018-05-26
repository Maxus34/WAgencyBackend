<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\records\ProductRecord */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Админ', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['/admin/product']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><b>Продукт: </b>"<?= Html::encode($this->title) ?>"</h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно желаете удалить данную категорию?',
                'method' => 'post',
            ],
        ]);?>
    </p>

    <hr>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
                'value' => function () use ($model) {
                    $image = $model->getMainImage();
                    return Html::img($image->getUrl([150, 150]), ['height' => 150, 'width' => 150]);
                },
                'format' => 'html'
            ]
        ],
    ]) ?>
</div>

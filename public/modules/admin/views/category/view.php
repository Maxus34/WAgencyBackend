<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\records\CategoryRecord */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Админ', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <h1><b>Категория: </b>"<?= Html::encode($this->title) ?>"</h1>

    <div class="row mb-2 mt-2">
        <div class="col-sm-3">
            <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-block']) ?>
        </div>

        <div class="col-sm-6">
            <?= Html::a('Добавить дочернюю категорию', ["child-category/create?parentId={$model->id}"], ['class' => 'btn btn-success btn-block']) ?>
        </div>

        <div class="col-sm-3">
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-block',
                'data' => [
                    'confirm' => 'Вы действительно желаете удалить данную категорию?',
                    'method' => 'post',
                ],
            ]);?>
        </div>
    </div>

    <hr>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
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

    <hr>

    <h2>Вложенные категории</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '50']
            ],
            'name',
            [
                'label' => 'Изображение',
                'value' => function ($data) {
                    return Html::img($data->getMainImage()->getUrl([50, 50]), ['height' => 50, 'width' => 50]);
                },
                'format' => 'html'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Действия',
                'headerOptions' => ['width' => '70'],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = "/admin/child-category/view?id=$model->id";
                        return $url;
                    }
                    if ($action === 'update') {
                        $url = "/admin/child-category/update?id=$model->id";
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url = "/admin/child-category/delete?id=$model->id";
                        return $url;
                    }
                }
            ],
        ],
    ]); ?>
</div>
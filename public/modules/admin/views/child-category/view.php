<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\records\ChildCategoryRecord */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['/admin/category']];
$this->params['breadcrumbs'][] = ['label' => $model->parent->name, 'url' => ["/admin/category/view?id={$model->parent->id}"]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <h1><b>Дочерняя категория: </b>"<?= Html::encode($this->title) ?>"</h1>
    <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы действительно желаете удалить данную категорию?',
            'method' => 'post',
        ],
    ]);?>

    <hr>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'parent',
                'value' => function () use($model) {
                    return $model->parent->name;
                }
            ],
            [
                'label' => 'Изображение',
                'value' => function () use ($model) {
                    $image = $model->getMainImage();
                    return Html::img($image->getUrl([100, 100]), ['height' => 100, 'width' => 100]);
                },
                'format' => 'html'
            ]
        ],
    ]) ?>
</div>
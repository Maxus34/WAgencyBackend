<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\records\CategoryRecord */

$this->title = 'Админ-панель';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Админ - панель</h1>
<div class="row">
    <div class="col-xs-6">
        <?= Html::a('Категории', ['/admin/category'], ['class' => 'btn btn-block btn-primary']) ?>
    </div>
    <div class="col-xs-6">
        <?= Html::a('Продукты', ['/admin/product'], ['class' => 'btn btn-block btn-primary']) ?>
    </div>
</div>

<hr>
<h2>Заказы</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'id',
            'headerOptions' => ['width' => '50']
        ],
        'qty',
        'sum',
        [
            'attribute' => 'status',
            'format' => 'html',
            'value' => function ($data) {
                return !$data->status ? '<span class="text-warning">Активен</span>' : '<span class="text-success">Завершен</span>';
            }
        ],
        'name',
        'email',
        'phone',
        'createdAt',
        [
            'class' => 'yii\grid\ActionColumn',
            'header'=>'Действия',
            'headerOptions' => ['width' => '70'],
        ],
    ],
]); ?>


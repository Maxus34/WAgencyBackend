<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\records\OrderRecord */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1>Просмотр заказа №<?= $model->id ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'createdAt',
            'updatedAt',
            'qty',
            'sum',
            [
                'attribute' => 'status',
                'value' => !$model->status ? '<span class="text-warning">Активен</span>' : '<span class="text-success">Завершен</span>',
                'format' => 'html',
            ],
            'name',
            'surname',
            'patronymic',
            'email:email',
            'phone',
        ],
    ]) ?>
    <hr>
    <h4>Товары:</h4>
    <?php $items = $model->items;?>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>Наименование</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <th>Сумма</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($items as $item):?>
                <tr>
                    <td><a href="<?= \yii\helpers\Url::to(['/product/view', 'id' => $item->productId])?>"><?= $item->product['name']?></a></td>
                    <td><?= $item['qtyItems']?></td>
                    <td><?= $item->product['price']?></td>
                    <td><?= $item['sumItems']?></td>
                </tr>
            <?php endforeach?>
            </tbody>
        </table>
    </div>
</div>

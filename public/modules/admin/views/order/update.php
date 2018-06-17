<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrderRecord */

$this->title = 'Обновить заказ: №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '#' . $model->id , 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="order-update">
    <h1>Редактирование заказа №<?= $model->id ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

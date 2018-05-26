<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\records\ChildCategoryRecord */

$this->title = 'Изменить дочернюю категорию "' . $model -> name . '"';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['/admin/category']];
$this->params['breadcrumbs'][] = ['label' => $model->parent->name, 'url' => ["/admin/category/view?id={$model->parent->id}"]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $category app\models\records\CategoryRecord */
/* @var $model app\models\records\ChildCategoryRecord */

$this->title = 'Создать дочернюю категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['/admin/category']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ["/admin/category/view?id={$category->id}"]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

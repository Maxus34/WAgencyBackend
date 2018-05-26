<?php

use yii\helpers\Html;


/** @var $this yii\web\View */
/** @var $model app\models\records\CategoryRecord */
/** @var $categories array */

$this->title = 'Создать продукт';
$this->params['breadcrumbs'][] = ['label' => 'Админ', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['/admin/product']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'      => $model,
        'categories' => $categories
    ]) ?>

</div>
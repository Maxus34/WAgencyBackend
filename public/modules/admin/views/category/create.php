<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\records\CategoryRecord */

$this->title = 'Создать категорию';
$this->params['breadcrumbs'][] = ['label' => 'Админ',  'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['/admin/category']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

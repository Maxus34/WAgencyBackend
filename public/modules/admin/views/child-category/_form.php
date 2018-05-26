<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\components\PictureSelect;

/* @var $this yii\web\View */
/* @var $model app\models\records\ChildCategoryRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= PictureSelect::widget([
        'model' => $model,
        'attribute' => 'main-image'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

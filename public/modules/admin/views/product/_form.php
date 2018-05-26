<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\components\PictureSelect;

/* @var $this yii\web\View */
/* @var $model app\models\records\ProductRecord */
/* @var $categories array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])  ?>
    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'type')->dropDownList([
            '1' => 'Премиум',
            '2' => 'Стандарт',
            '3' => 'Бюджет'
    ])  ?>

    <div class="form-group field-category-parent_id has-success">
        <label class="control-label" for="category-parent_id">Выберите категорию</label>
        <select id="category-parent_id" class="form-control" name="ProductRecord[catId]">

            <?php foreach($categories as $category): ?>
                <?php foreach($category->childs as $child): ?>
                    <option value="<?=$child->id?>"><b><?=$category->name?></b> > <?= $child->name ?></option>
                <?php endforeach; ?>
            <?php endforeach;?>

        </select>
    </div>


    <?= PictureSelect::widget([
        'model' => $model,
        'attribute' => 'main-image'
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
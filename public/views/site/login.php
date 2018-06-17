<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-sm-8 col-sm-offset-2">
    <h2 class="text-primary">Войти</h2>

    <?php $form = ActiveForm::begin([]); ?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>



    <div class="form-group">
        <?= Html::submitButton('Войти', ['class' => 'btn btn-outline-success', 'name' => 'login-button']) ?>
        <?= Html::resetButton('Отмена', ['class' => 'btn btn-outline-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>




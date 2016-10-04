<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Webboard */
/* @var $form yii\widgets\ActiveForm */

$model->CreateDate=date('Y-m-d');

?>
<div class="webboard-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CreateDate')->textInput() ?>

    <?= $form->field($model, 'Question')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Details')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'Name')->textInput(['maxlength' => true]) ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

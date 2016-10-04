<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WebboardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webboard-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'QuestionID') ?>

    <?= $form->field($model, 'CreateDate') ?>

    <?= $form->field($model, 'Question') ?>

    <?= $form->field($model, 'Details') ?>

    <?= $form->field($model, 'Name') ?>

    <?php // echo $form->field($model, 'View') ?>

    <?php // echo $form->field($model, 'Reply') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

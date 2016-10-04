<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$model->CreateDate = date('Y-m-d');
$this->title = 'ตอบกระทู้';
$this->params['breadcrumbs'][] = ['label' => 'Webboards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach ($head as $h)?>
<div class="row">
<table class="table table-condensed">
    <tr>
        <td align="center">
            <h2> <?php echo $h['Question'] ;?></h2>
        </td>
    </tr>
    <tr>
        <td>
             <h4> <?php echo $h['Details'] ;?></h4>
        </td>
    </tr>
    <tr>
        <td>
             <h4> <?php echo $h['Name'] ;?></h4>
        </td>
    </tr>
</table>
</div>  



<div class="row">
<div class="webboard-form">
   <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'Details')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'Name')->textInput(['maxlength' => true]) ?>
<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
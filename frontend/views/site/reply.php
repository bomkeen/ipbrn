<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$model->CreateDate = date('Y-m-d');
$this->title = 'ตอบกระทู้';
$this->params['breadcrumbs'][] = ['label' => 'Webboards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
include_once '../../inc/thaidate.php';
?>
<?php foreach ($head as $h)?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
<table class="table table-responsive">
    <tr bgcolor="#F06292">
        <td width="10%" >
            หัวข้อ
        </td>
        <td align="center" >
            <h2> <?php echo $h['Question'] ;?></h2>
        </td>
    </tr>
    <tr>
        <td width="10%" bgcolor="#F8BBD0">
            รายละเอียด
        </td>
        <td bgcolor="#FCE4EC">
             <h4> <?php echo $h['Details'] ;?></h4>
        </td>
    </tr>
    <tr>
        <td width="10%" bgcolor="#F8BBD0">
            ผู้ตั้งกระทู้
        </td>
        <td bgcolor="#FCE4EC">
             <h5> <?php echo $h['Name'] ;?></h5>
        </td>
    </tr>
</table>
</div>  
</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
<?php    foreach ($list as $l) { ?>
        <?php echo thaidate($l['CreateDate']) ;?>
        <table class="table table-responsive">
  <tr>
        <td width="10%" bgcolor="#4FC3F7">
            รายละเอียด
        </td>
        <td bgcolor="#E1F5FE">
             <h4> <?php echo $l['Details'] ;?></h4>
        </td>
    </tr>
    <tr>
        <td width="10%" bgcolor="#4FC3F7">
            ผู้แสดงความคิดเห็น
        </td>
        <td bgcolor="#E1F5FE">
             <h5> <?php echo $l['Name'] ;?></h5>
        </td>
    </tr>
</table>
        <br><br>
<?php  } ?>
</div>  
</div>


<div class="row">
    
    <div class="col-md-6 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel panel-heading">
                แสดงความคิดเห็น
            </div>
            
        <div class="panel-body">
   <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'Details')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'Name')->textInput(['maxlength' => true]) ?>
<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>
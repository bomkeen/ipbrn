<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Html;
include_once '../../inc/thaidate.php';
/* @var $this yii\web\View */
/* @var $searchModel common\models\WebboardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="page-header">
      <h2>กระดานสนทนา</h2>
</div>
<div class="container-fluid">

  
 

    <p>
        <?= Html::a('ตั้งกระทู้ใหม่', ['create'], ['class' => 'glyphicon glyphicon-plus btn btn-success']) ?>
    </p>
    <div class="row">
        <div class="col-md-12">
     <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                //'showPageSummary' => true,
                'responsive' => true,
              
                'columns' => [
            
                     [
           'label'=>'วันที่',
                          'width'=>'5%',
           'format' => 'raw',
       'value'=>function ($data)  {
            return thaidate($data['CreateDate']);
        }
    ],
             [
                        'attribute' => 'Question',
                        'label' => 'หัวข้อคำถาม',
                      
                                       ],
            //'Question',
            //'Details:ntext',
            
            [
                'attribute'=>'Name',
                'label'=>'ผู้ตั้งคำถาม',
                'width'=>'10%',
            ],
          
   [
'label'=>'ลงบันทึกข้อมูล',
     'width'=>'10%',
'format' => 'raw',
'value'=>function ($data) {
return Html::a('แสดงความคิดเห็น',['site/reply','id'=>$data['QuestionID']],['class' => 'btn btn-warning glyphicon glyphicon-new-window']);


}]
                ],
            ]);
            ?>
    </div></div>
   
</div>

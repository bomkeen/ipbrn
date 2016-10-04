<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Html;
include_once '../../inc/thaidate.php';
/* @var $this yii\web\View */
/* @var $searchModel common\models\WebboardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Webboards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Webboard', ['create'], ['class' => 'btn btn-success']) ?>
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
           'label'=>'จังหวัด',
                          'width'=>'5%',
           'format' => 'raw',
       'value'=>function ($data)  {
            return thaidate($data['CreateDate']);
        }
    ],
             [
                        'attribute' => 'Question',
                        'label' => 'สถานพยาบาล',
                      
                                       ],
            //'Question',
            //'Details:ntext',
            
            [
                'attribute'=>'Name',
                'label'=>'ชื่อ',
                'width'=>'10%',
            ],
          
   [
'label'=>'ลงบันทึกข้อมูล',
     'width'=>'10%',
'format' => 'raw',
'value'=>function ($data) {
return Html::a('แสดงความคิดเห็น',['webboard/reply','id'=>$data['QuestionID']],['class' => 'btn btn-warning glyphicon glyphicon-new-window']);


}]
                ],
            ]);
            ?>
    </div></div>
   
</div>

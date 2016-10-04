<?php

use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\SeriesDataHelper;
use kartik\export\ExportMenu;
use yii\helpers\Html;

$this->title = 'CMI ภาพรวมของหน่วยบริการในเขต 4 สระบุรี';
//$this->params['breadcrumbs'][] = ['label' => 'ข้อมูลการให้บริการผู้ป่วยใน', 'url' => ['/ipdfund']];
$this->params['breadcrumbs'][] = $this->title;
include_once '../../inc/thaidate.php';
?>
 <!--////////////////////////////////-->
     <!--////////////////////////////////////-->
<div class="container-fluid">
 
    <br>
    <div class="row">
         <div class="col-md-6">
                                  <?php 
       echo Highcharts::widget([
               
            'options' => [
    
               
                'title' => ['text' => 'CMI ภาพรวมของหน่วยบริการในเขต 4 สระบุรี'],
                'xAxis' => [
                    'categories' => new SeriesDataHelper($dataProvider, ['yname']),
                    'nameToX'=> true
                ],
                'yAxis' => [
                    'title' => ['text' => 'ค่า CMI']
                ],
                'series' => [
                    ['type' => 'column','name' => 'ปีงบประมาณ'
                    ,'data' => new SeriesDataHelper($dataProvider, ['cmi:float']),
               ],
                ]
    ]])
        ?>
             <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'showPageSummary' => true,
   
    'columns' => [
           [
    'class'=>'kartik\grid\SerialColumn',
               'contentOptions'=>['class'=>'kartik-sheet-style'],
    'width'=>'36px',
    'header'=>'ลำดับ',
    'headerOptions'=>['class'=>'kartik-sheet-style']
    
],
      [
            'attribute'=>'yname',
            'label'=>'ปีงบประมาณ',
            'hAlign'=>'left'
        ],   
  [
            'attribute'=>'cmi',
            'label'=>'CMI',
                    'format'=>['decimal',2], 
           
                    'hAlign'=>'right'
        ],
        
     
      
     ],
]); ?>
                             
        </div>
        <div class="col-md-6">
            <div class="row">
   
            </div>
            <div class="row">
                 <form class="form-inline"id="form1" name="form1" method="post" >
                <select class="form-control" name="year" id="year">
                    <?php
                    $list = date('Y');
                    for ($i = 0; $i <= 5; $i++) {
                        $l = $list - $i;
                        $th = $l + 543; ?>
                     <option value="<?=$l ;?>"  <?php if($l==$y) echo 'selected'; ?> >ปีงบประมาณ <?=$th ;?></option>
                 <?php   }?>

                </select>
                <select class="form-control" name="m1" id="m1">
                    <?php
                    foreach ($m_list as $m) { ?>
  <option value="<?=$m['m_num']?>"  <?php if($m['m_num']==$m1) echo 'selected'; ?> ><?=$m['m_name']?></option>
                 <?php   } ?>
                </select>
                <select class="form-control" name="m2" id="m2">
                   <?php
                    foreach ($m_list as $m) { ?>
  <option value="<?=$m['m_num']?>"  <?php if($m['m_num']==$m2) echo 'selected'; ?> ><?=$m['m_name']?></option>
                 <?php   } ?>
                </select>

                <input type="hidden" name="form1" id="form1" value="true" />
                <input class="btn btn-success" type="submit" name="Submit" value="แสดงข้อมูล" />
            </form>
            </div>
            <br>
            <div class="row">
            <?= GridView::widget([
    'dataProvider' => $rs_provider,
    //'showPageSummary' => true,
   
    'columns' => [
                  [
           'label'=>'จังหวัด',
           'format' => 'raw',
       'value'=>function ($data) use ($y,$dch1,$dch2,$m1,$m2) {
            return Html::a($data['PURPROVDESCR'],['cmi/pro'
                ,'m1'=>$m1,'m2'=>$m2,'y'=>$y,'dch1'=> $dch1,'dch2'=>$dch2,'prov1'=>$data['PROV1']]);
        },
    ],
      
  [
            'attribute'=>'cmi',
            'label'=>'CMI',
                    'format'=>['decimal',2], 
           
                    'hAlign'=>'right'
        ],
        
     
      
     ],
]); ?>
            </div>
        </div>
        
    </div>
</div>

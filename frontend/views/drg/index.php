<?php

use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use kartik\export\ExportMenu;
use yii\helpers\Html;

$this->title = 'อันดับกลุ่มโรคที่มีการ Admit ';
$this->params['breadcrumbs'][] = ['label' => 'ข้อมูลการให้บริการผู้ป่วยใน', 'url' => ['/ipdfund']];
$this->params['breadcrumbs'][] = $this->title;
include_once '../../inc/thaidate.php';
?>
<h1>drg/index</h1>
 <!--////////////////////////////////-->
       <div class="row">
           <div class="col-md-10">
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
    </div>
    <br>
    <!--////////////////////////////////////-->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                       <?php 
       echo Highcharts::widget([
               
            'options' => [
                'title' => ['text' => 'อันดับกลุ่มโรคที่มีการ Admit ที่สถานพยาบาลในเขต'],
                'xAxis' => [
                    'categories' => $na
                ],
                'yAxis' => [
                    'title' => ['text' => 'จำนวนผู้รับบริการ']
                ],
                'series' => [
                    ['type' => 'column','name' => 'จำนวนผู้รับบริการ', 'data' => $n],
                ]
    ]])
        ?>
                     <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'showPageSummary' => true,
    'panel'=>[
        'before' => '***ข้อมูลหระหว่าง   '.  dchmonth($dch1) .'    ถึง    '. dchmonth($dch2),
           // 'before' => 'ข้อมูลหระหว่างวันที่   '.thaidate($date1) .'    ถึง    '.thaidate($date2),
    ],
    'columns' => [
           [
    'class'=>'kartik\grid\SerialColumn',
               'contentOptions'=>['class'=>'kartik-sheet-style'],
    'width'=>'36px',
    'header'=>'ลำดับ',
    'headerOptions'=>['class'=>'kartik-sheet-style']
    
],
      [
            'attribute'=>'DRG',
            'label'=>'DRG Name',
             
            'pageSummary'=>'รวม',
                    'hAlign'=>'left'
        ],   
  [
            'attribute'=>'N',
            'label'=>'จำนวนครั้ง',
                    'format'=>['decimal',0], 
            'pageSummary'=>true,
                    'hAlign'=>'right'
        ],
        [
            'attribute'=>'ADJRW',
            'label'=>'Sum Of ADJRW',
            'pageSummary'=>true,
            'format'=>['decimal',4],
            'hAlign'=>'right'
        ],
                 [
            'attribute'=>'SUMNET',
            'label'=>'จำนวนเงินที่ชดเชย (บาท)',
            'pageSummary'=>true,
            'format'=>['decimal',2],
            'hAlign'=>'right'
        ],
     
      
     ],
]); ?>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php

use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\SeriesDataHelper;
use kartik\export\ExportMenu;
use yii\helpers\Html;

include_once '../../inc/thaidate.php';

?>
<!--/////////////ส่งออก chart//////////////-->
<script src="../../inc/highcharts.js"></script>
<script src="../../inc/exporting.js"></script>
<!--////////////////////////////////-->
 <!--////////////////////////////////-->
     <!--////////////////////////////////////-->
<div class="container-fluid">
 
    <br>
    <div class="row">
        <?php 
//        foreach ($nn as $mm){
//            echo $mm.',';
//        }
        ?>
        <div class="col-md-6">
                                  <?php 
       echo Highcharts::widget([
               
            'options' => [
                 'data' => [
           
        ],
               
                'title' => ['text' => 'CMI ตามประเภทสถานบริการ เขต 4 สระบุรี'],
                'xAxis' => [
                    'categories' => new SeriesDataHelper($rs_provider, ['SUBTYPEDESCR']),
                    'nameToX'=> true
                ],
                'yAxis' => [
                    'title' => ['text' => 'ค่า CMI']
                ],
  
                'series' => [
                    ['type' => 'column','name' => 'CMI'
                    ,'data' => new SeriesDataHelper($rs_provider, ['cmi:float']),]
                ]
    ]])
        ?>
           
                             
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
           'label'=>'ประเภทสถานบริการ',
           'format' => 'raw',
       'value'=>function ($data) use ($y,$dch1,$dch2,$m1,$m2) {
            return Html::a($data['SUBTYPEDESCR'],['cmi/htypepro'
                ,'m1'=>$m1,'m2'=>$m2,'y'=>$y,'dch1'=> $dch1,'dch2'=>$dch2,'subtype'=>$data['SUBTYPE']]);
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

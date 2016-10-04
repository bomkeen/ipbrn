<?php

use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\SeriesDataHelper;
use kartik\export\ExportMenu;
use yii\helpers\Html;
//
//$this->title = 'CMI ภาพรวมของหน่วยบริการในเขต 4 สระบุรี';
////$this->params['breadcrumbs'][] = ['label' => 'ข้อมูลการให้บริการผู้ป่วยใน', 'url' => ['/ipdfund']];
//$this->params['breadcrumbs'][] = $this->title;
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
         <div class="col-md-6">
                                  <?php 
       echo Highcharts::widget([
               
            'options' => [
    
               
                'title' => ['text' => 'จำนวนการไปรับบริการนอกเขตแยกตามประเภทการรับบริการ'],
                'xAxis' => [
                    'categories' => new SeriesDataHelper($IPAEC, ['GYEAR']),
                    'nameToX'=> true
                ],
                     'yAxis' => [
                    'title' => ['text' => null],
                     'labels' =>  [
                'format' => '{value} ครั้ง'
            ]],
                'series' => [
                    ['type' => 'column','name' => 'IPAEC'
                    ,'data' => new SeriesDataHelper($IPAEC, ['N:int']),
               ],
   
                 ['type' => 'column','name' => 'IPINRGC'
                    ,'data' => new SeriesDataHelper($IPINRGC, ['N:int']),
               ],     
                ]
    ]])
        ?>
            
        </div>
        <div class="col-md-6">
          <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'showPageSummary' => true,
                'panel' => [
                    'type'=>GridView::TYPE_PRIMARY,
                    'heading' => ''
                // 'before' => 'ข้อมูลหระหว่างวันที่   '.thaidate($date1) .'    ถึง    '.thaidate($date2),
                ],
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'width' => '36px',
                        'header' => 'ลำดับ',
                        'headerOptions' => ['class' => 'kartik-sheet-style']
                    ],
       [
                        'attribute' => 'GYEAR',
                        'label' => 'ปีงบประมาณ',
                        //'format' => ['decimal', 0],
                        'pageSummary'=>'รวม',
                        //'hAlign' => 'right'
                    ],
                      [
                        'attribute' => 'IPAEC',
                        'label' => 'IPAEC',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                    [
                        'attribute' => 'IPINRGC',
                        'label' => 'IPINRGC',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                    [
                        'attribute' => 'N',
                        'label' => 'จำนวน(ครั้ง)',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
           
                ],
            ]);
            ?>
        </div>
        
    </div>
</div>

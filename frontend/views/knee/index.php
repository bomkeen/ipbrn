<?php
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\SeriesDataHelper;
use kartik\export\ExportMenu;
use yii\helpers\Html;
?>
<div class="page-header">
    <h3>ข้อมูลการให้บริการเฉพาะโรค ข้อเข่า เขต 4 สระบุรี</h3>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
                                         <?php 
       echo Highcharts::widget([
               
            'options' => [
    
               
                'title' => ['text' => 'แยกกองทุนตามปีงบประมาณ เขต 4 สระบุรี'],
                'xAxis' => [
                    'categories' => new SeriesDataHelper($dataProvider, ['GYEAR']),
                    'nameToX'=> true
                ],
                                 'yAxis' => [
                    'title' => ['text' => null],
                     'labels' =>  [
                'format' => '{value} ครั้ง'
            ]],
                'series' => [
                    ['type' => 'column','name' => 'IPAEC'
                    ,'data' => new SeriesDataHelper($dataProvider, ['IPAEC:int']),
               ],
                        ['type' => 'column','name' => 'IPINRGC'
                    ,'data' => new SeriesDataHelper($dataProvider, ['IPINRGC:int']),
               ],
                         ['type' => 'column','name' => 'IPAER'
                    ,'data' => new SeriesDataHelper($dataProvider, ['IPAER:int']),
               ],
                        ['type' => 'column','name' => 'IPINRGR'
                    ,'data' => new SeriesDataHelper($dataProvider, ['IPINRGR:int']),
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
                        'pageSummary'=>'รวม',
                        'hAlign' => 'left'
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
                        'attribute' => 'IPAER',
                        'label' => 'IPAER',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                     [
                        'attribute' => 'IPINRGR',
                        'label' => 'IPINRGR',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                     [
                        'attribute' => 'n',
                        'label' => 'รวม',
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
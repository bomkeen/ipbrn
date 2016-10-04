<?php
/* @var $this yii\web\View */
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use kartik\export\ExportMenu;
use yii\helpers\Html;
$this->title = 'ข้อมูลคนในเขตออกไปรับบริการนอกเขต แยกตามกองทุน';
$this->params['breadcrumbs'][] = ['label' => 'ข้อมูลการให้บริการผู้ป่วยใน', 'url' => ['/ipdfund']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-header">
   <h3>ข้อมูลคนในเขตออกไปรับบริการนอกเขต แยกตามกองทุน</h3>             
         </div>
 
<div class="container-fluid">
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
    
    <div class="row">
    <div class="col-md-4">
    <?php 
       echo Highcharts::widget([
               
            'options' => [
                'title' => ['text' => 'ข้อมูลคนในเขตออกไปรับบริการนอกเขต แยกตามกองทุน'],
                'xAxis' => [
                    'categories' => $na
                ],
                           'yAxis' => [
                    'title' => ['text' => null],
                     'labels' =>  [
                'format' => '{value} ครั้ง'
            ]],
                'series' => [
                    ['type' => 'column','name' => 'กองทุน', 'data' => $n],
                ]
    ]])
        ?>
        </div>
        <div class="col-md-8">
            <?php 
//            echo ExportMenu::widget([
//    'dataProvider' => $dataProvider]);
include_once '../../inc/thaidate.php';
            ?>
        
            <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'showPageSummary' => true,
    'panel'=>[
        'type'=>GridView::TYPE_PRIMARY,
        'heading' => '***ข้อมูลหระหว่าง   '.  dchmonth($dch1) .'    ถึง    '. dchmonth($dch2),
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
           'label'=>'เขตบริการสุขภาพ',
           'format' => 'raw',
       'value'=>function ($data) use ($y,$dch1,$dch2,$m1,$m2) {
            return Html::a($data['REGION_NAME'],['ipdfund/hmainpro'
                ,'m1'=>$m1,'m2'=>$m2,'y'=>$y,'dch1'=> $dch1,'dch2'=>$dch2,'region'=>$data['REGIONCODE']]);
        },
    ],
        
//        [
//            'attribute' => 'PURPROVDESCR',
//            'label' => 'จังหวัด',
//            'pageSummary'=>'รวม',
//        ],
                [
            'attribute'=>'IPINRGR',
            'label'=>'IPINRGR',
                    'format'=>['decimal',0], 
            'pageSummary'=>true,
                    'hAlign'=>'right'
        ],
//        [
//            'attribute'=>'IPINRGR',
//            'label'=>'IPINRGR',
//             'format'=>'html',
//          'value'=>function($data){
//            return number_format((float)$data['IPINRGR']);
//          },
//            'pageSummary'=>true
//        ],
//        [
//            'attribute'=>'IPNB',
//            'label'=>'IPNB',
//            'pageSummary'=>true,
//            'format'=>['decimal',0],
//            'hAlign'=>'right'
//        ],
        [
            'attribute'=>'IPAER',
            'label'=>'IPAER',
            'pageSummary'=>true,
            'format'=>['decimal',0],
            'hAlign'=>'right'
        ],
        [
            'attribute'=>'IPAEC',
            'label'=>'IPAEC',
            'pageSummary'=>true,
            'format'=>['decimal',0],
            'hAlign'=>'right'
        ],
//        [
//            'attribute'=>'CATARACT',
//            'label'=>'CATARACT',
//            'pageSummary'=>true,
//            'format'=>['decimal',0],
//            'hAlign'=>'right'
//        ],
        [
            'attribute'=>'IPINRGC',
            'label'=>'IPINRGC',
            'pageSummary'=>true,
            'format'=>['decimal',0],
            'hAlign'=>'right'
        ],
//        [
//            'attribute'=>'IPPUC',
//            'label'=>'IPPUC',
//            'pageSummary'=>true,
//            'format'=>['decimal',0],
//            'hAlign'=>'right'
//        ],
        [
            'attribute'=>'N',
            'label'=>'รวม',
            'pageSummary'=>true,
            'format'=>['decimal',0],
            'hAlign'=>'right'
        ],
        
      
     ],
]); ?>
        </div>
    </div>
   
</div>

<?php
/* @var $this yii\web\View */
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use kartik\export\ExportMenu;
$this->title = 'ข้อมูลการให้บริการผู้ป่วยในของจังหวัด';
$this->params['breadcrumbs'][] = ['label' => 'ข้อมูลการให้บริการผู้ป่วยใน', 'url' => ['/ipdfund']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-header">
             <h3>ข้อมูลการให้บริการผู้ป่วยในของจังหวัด <?php foreach ($p_name as $p){ echo $p['PROVINCE_NAME'];} ?></h3>             
         </div>

<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
    <?php 
//       echo Highcharts::widget([
//               
//            'options' => [
//                'title' => ['text' => 'ข้อมูลการให้บริการผู้ป่วยในแยกตามกองทุน'],
//                'xAxis' => [
//                    'categories' => $na
//                ],
//                'yAxis' => [
//                    'title' => ['text' => 'จำนวนผู้รับบริการ']
//                ],
//                'series' => [
//                    ['type' => 'column','name' => 'จำนวนผู้รับบริการ', 'data' => $n],
//                ]
//    ]])
        ?>
        </div>
    </div>
    <!--////////////////////////////////-->
       <div class="row">
           <div class="col-md-10">
              <form class="form-inline"id="form1" name="form1" method="post" >
                  <select class="form-control" name="prov1" id="prov1">
                     <?php foreach ($p_list as $p) { ?>
  <option value="<?=$p['PROVINCE_ID']?>"  <?php if($p['PROVINCE_ID']==$prov1) echo 'selected'; ?> ><?=$p['PROVINCE_NAME']?></option>
                 <?php   } ?>
                  </select>
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
        <div class="row">
        <div class="col-md-12">
            <?php 
                                             include_once '../../inc/thaidate.php';
//            echo ExportMenu::widget([
//    'dataProvider' => $dataProvider]);
            ?>
        
            <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'showPageSummary' => true,
    'panel'=>[
       'type'=>GridView::TYPE_PRIMARY,
            'heading' => '***ข้อมูลหระหว่าง   '.  dchmonth($dch1) .'    ถึง    '. dchmonth($dch2),
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
            'attribute' => 'HCODEDESCR',
            'label' => 'สถานบริการ',
            'pageSummary'=>'รวม',
        ],
        [
            'attribute'=>'IPINRGR',
            'label'=>'IPINRGR',
            'pageSummary'=>true,
            'format'=>['decimal',0],
            'hAlign'=>'right'
        ],
        [
            'attribute'=>'IPNB',
            'label'=>'IPNB',
            'pageSummary'=>true,
            'format'=>['decimal',0],
            'hAlign'=>'right'
        ],
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
        [
            'attribute'=>'CATARACT',
            'label'=>'CATARACT',
            'pageSummary'=>true,
            'format'=>['decimal',0],
            'hAlign'=>'right'
        ],
        [
            'attribute'=>'IPINRGC',
            'label'=>'IPINRGC',
            'pageSummary'=>true,
            'format'=>['decimal',0],
            'hAlign'=>'right'
        ],
        [
            'attribute'=>'IPPUC',
            'label'=>'IPPUC',
            'pageSummary'=>true,
            'format'=>['decimal',0],
            'hAlign'=>'right'
        ],
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

<?php
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use kartik\export\ExportMenu;
use yii\helpers\Html;
$this->title = 'จำนวนผู้ป่วยแต่ละจังหวัดที่ไปรับบริการกรณีฉุกเฉินข้ามเขต';
$this->params['breadcrumbs'][] = ['label' => 'การให้บริการผู้ป่วย ข้อเข่า', 'url' => ['/knee/knee']];
$this->params['breadcrumbs'][] = $this->title;
include_once '../../inc/thaidate.php';
?>
<div class="page-header">
<h4>การให้บริการผู้ป่วย ข้อเข่า แยกตามกองทุน  &nbsp ข้อมูลหระหว่าง  <?php echo dchmonth($dch1); ?>    ถึง   <?php echo dchmonth($dch2); ?></h4></h4>
</div>
<div class="container-fluid">
     <div class="row">
             <div class="col-md-12">
          
                    <form class="form-inline"id="form1" name="form1" method="post" >
          
                        <select class="form-control" name="year" id="year">
                    <?php
                    $list = date('Y');
                    for ($i = 0; $i <= 5; $i++) {
                        $l = $list - $i;
                        $th = $l + 543;
                        ?>
                        <option value="<?= $l; ?>"  <?php if ($l == $y) echo 'selected'; ?> >ปีงบประมาณ <?= $th; ?></option>
                    <?php } ?>

                </select>
                <select class="form-control" name="m1" id="m1">
                    <?php foreach ($m_list as $m) { ?>
                        <option value="<?= $m['m_num'] ?>"  <?php if ($m['m_num'] == $m1) echo 'selected'; ?> ><?= $m['m_name'] ?></option>
                    <?php } ?>
                </select>
                <select class="form-control" name="m2" id="m2">
<?php foreach ($m_list as $m) { ?>
                        <option value="<?= $m['m_num'] ?>"  <?php if ($m['m_num'] == $m2) echo 'selected'; ?> ><?= $m['m_name'] ?></option>
<?php } ?>
                </select>
                <input type="hidden" name="form1" id="form1" value="true" />
                <input class="btn btn-success" type="submit" name="Submit" value="แสดงข้อมูล" />
            </form>
                    <br>
             <?php 
//       echo Highcharts::widget([
//               
//            'options' => [
//                
//                'title' => ['text' => 'จำนวนผู้ป่วยแต่ละจังหวัดที่ไปรับบริการกรณีฉุกเฉินข้ามเขต กองทุน'.$fund],
//                'xAxis' => [
//                    'categories' => $na
//                ],
//                'yAxis' => [
//                    'title' => ['text' => 'จำนวนครั้ง']
//                ],
//  
//                'series' => [
//                    ['type' => 'column','name' => 'จังหวัด'
//                    ,'data' => $n],
//                ]
//    ]])
        ?>
              <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'showPageSummary' => true,
                'panel' => [
                    'type'=>GridView::TYPE_PRIMARY,
                    'heading' => ' ระหว่าง   ' . dchmonth($dch1) . '    ถึง    ' . dchmonth($dch2),
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
           'label'=>'จังหวัด',
           'format' => 'raw',
       'value'=>function ($data) use ($y,$dch1,$dch2,$m1,$m2) {
            return Html::a($data['pro'],['knee/fundhcode'
                ,'m1'=>$m1,'m2'=>$m2,'y'=>$y,'dch1'=> $dch1,'dch2'=>$dch2,'prov2'=>$data['PROV2']]);
        },
    ],
                    [
                        'attribute' => 'IPAER',
                        'label' => 'IPAER',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                    [
                        'attribute' => 'IPAEC',
                        'label' => 'IPAEC',
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
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            
        </div>
    </div>
</div>
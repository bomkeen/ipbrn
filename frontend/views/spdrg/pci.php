<?php
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use kartik\export\ExportMenu;
use yii\helpers\Html;
$this->title = 'การให้บริการผู้ป่วย PCI ';
//$this->params['breadcrumbs'][] = ['label' => 'CMI ภาพรวมของหน่วยบริการในเขต 4 สระบุรี', 'url' => ['/cmi/index']];
$this->params['breadcrumbs'][] = $this->title;
include_once '../../inc/thaidate.php';
?>
<div class="page-header">
<h4>การให้บริการผู้ป่วย PCI  &nbsp ข้อมูลหระหว่าง  <?php echo dchmonth($dch1); ?>    ถึง   <?php echo dchmonth($dch2); ?></h4></h4>
<h4 > <font color='red'> All Hcoderegion</font></h4>
</div>
<div class="container-fluid">
    <div class="row">
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
    </div>
    <br>
    <div class="row">
     
        <div class="col-md-6">
         
                   
             <?php 
       echo Highcharts::widget([
               
            'options' => [
                
                'title' => ['text' => 'การให้บริการผู้ป่วย PCI แยกตามกองทุน เขต 4 สระบุรี'],
                'xAxis' => [
                    'categories' => $na
                ],
                            'yAxis' => [
                    'title' => ['text' => null],
                     'labels' =>  [
                'format' => '{value} ครั้ง'
            ]],
  
                'series' => [
                    ['type' => 'column','name' => 'กองทุน','data' => $n],
                  
                ]
    ]])
        ?>
                </div>
                    <div class="col-md-6">
              <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                //'showPageSummary' => true,
                'panel' => [
                    'type'=>GridView::TYPE_PRIMARY,
                    'heading' => 'ระหว่าง   ' . dchmonth($dch1) . '    ถึง    ' . dchmonth($dch2),
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
                        'attribute' => 'FUND',
                        'label' => 'กองทุน',
                        'hAlign' => 'left'
                    ],
                    [
                        'attribute' => 'n',
                        'label' => 'จำนวน(ครั้ง)',
                        'format' => ['decimal', 2],
                        'hAlign' => 'right'
                    ],
                ],
            ]);
            ?>
            </div>
         
    </div>
  
</div>
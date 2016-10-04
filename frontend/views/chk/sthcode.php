<?php

use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use kartik\export\ExportMenu;
use yii\helpers\Html;
//
$this->title = 'รายงานการส่งข้อติด C รายสถานบริการ';
$this->params['breadcrumbs'][] = ['label' => 'รายงานการส่งข้อติด C', 'url' => ['/chk/st']];
$this->params['breadcrumbs'][] = $this->title;
include_once '../../inc/thaidate.php';
?>
<div class="page-header">
    <h4>รายงานการส่งข้อติด C รายสถานบริการของจังหวัด <?php foreach ($p_name as $pp){ echo $pp['PROVINCE_NAME'];} ?> &nbsp ข้อมูลหระหว่าง  <?php echo dchmonth($dch1); ?>    ถึง   <?php echo dchmonth($dch2); ?></h4></h4>
</div>
<div class="container-fluid">
     <div class="row">
        <div class="col-md-12">
           
                    <form class="form-inline"id="form1" name="form1" method="post" >
                        <select class="form-control" name="prov1" id="prov1">
                            <?php foreach ($p_list as $p) { ?>
                                <option value="<?= $p['PROVINCE_ID'] ?>"  <?php if ($p['PROVINCE_ID'] == $prov1) echo 'selected'; ?> ><?= $p['PROVINCE_NAME'] ?></option>
                            <?php } ?>
                        </select>
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
               
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'showPageSummary' => true,
                        'panel' => [
                            'type' => GridView::TYPE_DANGER,
                            'heading' => 'จังหวัด  ' . $pp['PROVINCE_NAME'] . ' ระหว่าง   ' . dchmonth($dch1) . '    ถึง    ' . dchmonth($dch2),
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
                                'attribute' => 'HCODEDESCR',
                                'label' => 'สถานบริการ',
                                'hAlign' => 'left',
                                'pageSummary' => 'รวม',
                            ],
                            [
                        'attribute' => 's0',
                        'label' => 'ข้อมูลใหม่',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                    [
                        'attribute' => 's1',
                        'label' => 'ส่งข้อมูลไปยัง สปสช',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                     [
                        'attribute' => 's2',
                        'label' => 'ไม่ผ่านการตรวจสอบข้อมูลขั้นต้น',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                     [
                        'attribute' => 's3',
                        'label' => 'แก้ไขข้อมูลตอบกลับ',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                 [
                        'attribute' => 's4',
                        'label' => 'ผ่าน การตรวจสอบน',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                [
                        'attribute' => 's5',
                        'label' => 'ข้อมูลเก่าที่ไม่ผ่านการตรวจสอบ',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                [
                        'attribute' => 's8',
                        'label' => 'ข้อมูลเก่าที่ขอ  e-PAC',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                [
                        'attribute' => 's9',
                        'label' => 'ข้อมูลเก่าที่ขอ e-APPEAL',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                [
                        'attribute' => 'sZ',
                        'label' => 'ผ่าน การตรวจสอบน',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                [
                        'attribute' => 'sX',
                        'label' => 'ข้อมูลที่ถูกยกเลิก',
                        'format' => ['decimal', 0],
                        'pageSummary'=>true,
                        'hAlign' => 'right'
                    ],
                 [
                        'attribute' => 'sW',
                        'label' => 'ข้อมูลที่รอการอนุมัติ E-APPEAL',
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
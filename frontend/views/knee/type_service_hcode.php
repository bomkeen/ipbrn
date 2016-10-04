<?php

use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use kartik\export\ExportMenu;
use yii\helpers\Html;

$this->title = 'รายงานประเภทการไปรับบริการนอกเขตรายจังหวัด';
$this->params['breadcrumbs'][] = ['label' => 'การให้บริการผู้ป่วย ข้อเข่า', 'url' => ['/knee/knee']];
$this->params['breadcrumbs'][] = ['label' => 'รายงานประเภทการไปรับบริการนอกเขต', 'url' => ['/knee/typeservice']];
$this->params['breadcrumbs'][] = $this->title;
include_once '../../inc/thaidate.php';
?>
<div class="page-header">
    <h4>รายงานประเภทการไปรับบริการนอกเขตของผู้ป่วย ข้อเข่า ของจังหวัด <?php foreach ($p_name as $p){ echo $p['PROVINCE_NAME'];} ?> &nbsp ข้อมูลหระหว่าง  <?php echo dchmonth($dch1); ?>    ถึง   <?php echo dchmonth($dch2); ?></h4></h4>
</div>
<div class="container-fluid">
    <br>
    <div class="row">
        <div class="col-md-12">
          
                    <div class="row">
                        <form class="form-inline"id="form1" name="form1" method="post" >
                            <select class="form-control" name="prov2" id="prov2">
                                <?php foreach ($p_list as $p) { ?>
                                    <option value="<?= $p['PROVINCE_ID'] ?>"  <?php if ($p['PROVINCE_ID'] == $prov2) echo 'selected'; ?> ><?= $p['PROVINCE_NAME'] ?></option>
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
                    </div>
                    <br>
                    <div class="row">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'showPageSummary' => true,
                            'panel' => [
                                'type' => GridView::TYPE_PRIMARY,
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
                                    'attribute' => 'HMAINDESCR',
                                    'label' => 'สถานบริการ',
                                    'hAlign' => 'left',
                                    'pageSummary' => 'รวม',
                                ],
                                [
                                    'attribute' => 'IPAEC',
                                    'label' => 'IPAEC',
                                    'format' => ['decimal', 0],
                                    'pageSummary' => true,
                                    'hAlign' => 'right'
                                ],
                                [
                                    'attribute' => 'IPAEC_NET',
                                    'label' => 'จำนวนเงินชดเชยกองทุน IPAEC',
                                    'format' => ['decimal', 0],
                                    'pageSummary' => true,
                                    'hAlign' => 'right'
                                ],
                                [
                                    'attribute' => 'IPINRGC',
                                    'label' => 'IPINRGC',
                                    'format' => ['decimal', 0],
                                    'pageSummary' => true,
                                    'hAlign' => 'right'
                                ],
                                [
                                    'attribute' => 'IPINRGC_NET',
                                    'label' => 'จำนวนเงินชดเชยกองทุน IPINRGC',
                                    'format' => ['decimal', 0],
                                    'pageSummary' => true,
                                    'hAlign' => 'right'
                                ],
                                [
                                    'attribute' => 'N',
                                    'label' => 'รวม',
                                    'format' => ['decimal', 0],
                                    'pageSummary' => true,
                                    'hAlign' => 'right'
                                ],
                                [
                                    'attribute' => 'NET',
                                    'label' => 'จำนวนเงินชดเชยทั้งหมด',
                                    'format' => ['decimal', 0],
                                    'pageSummary' => true,
                                    'hAlign' => 'right'
                                ],
                            ],
                        ]);
                        ?>
                    </div>
               
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

        </div>
    </div>
</div>
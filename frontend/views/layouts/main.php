<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use kartik\nav\NavX;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>
    </head>
    <body>
<?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            //NavBar::begin($navBarOptions);
            NavBar::begin([
                'brandLabel' => 'ระบบรายงานกองทุนผู้ป่วยใน',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'ข้อมูลผู้ป่วยใน', 'items' => [
                        ['label' => 'ข้อมูลการให้บริการผู้ป่วยใน', 'url' => ['/ipdfund']],
                        ['label' => 'ข้อมูลการให้บริการผู้ป่วยของสถานพยาบาลในเขต', 'url' => ['/ipdfund/ipdsumfund']],
                        ['label' => 'ข้อมูลข้อมูลคนในเขตออกไปรับบริการต่างเขต', 'url' => ['/ipdfund/hmainregion']],
                        ['label' => 'อันดับกลุ่มโรคที่มีการ Admit ของสถานพยาบาลในเขต', 'url' => ['/drg/drgregion']],
                        ['label' => 'อันดับกลุ่มโรคที่มีการ Admit รับบริการนอกเขต', 'url' => ['/drg/hmain']],
                        ['label' => 'อันดับโรคหลักที่ให้บริการ', 'url' => ['/pdx/hcoderegion']],
                        ['label' => 'อันดับโรคหลักที่ไปรับบริการนอกเขต', 'url' => ['/pdx/hmainregion']],
                        ['label' => 'รายงานกลุ่มโรคที่มีค่าใช้จ่ายสูง ', 'url' => ['/drg/hightcost']],
                        ['label' => 'รายงานการส่งข้อมูลล่าช้า ', 'url' => ['/chk']],
                        ['label' => 'รายงานข้อมูลที่ติด C', 'url' => ['/chk/st']],
                    ]],
                ['label' => 'ข้อมูลการส่งต่อ', 'items' => [
                        ['label' => 'จำนวนการไปรับบริการนอกเขตแยกตามประเภทการรับบริการ', 'url' => ['/refer']],
                        ['label' => 'รายงานจังหวัดปลายทางนอกเขตที่มีการรับส่งต่อทั่วไป', 'url' => ['/refer/pro']],
                        ['label' => 'รายงานหน่วยบริการปลายทางที่รับส่งต่อทั่วไป', 'url' => ['/refer/hcode']],
                        ['label' => 'รายงานจังหวัดปลายทางนอกเขตที่ให้บริการฉุกเฉินข้ามเขต', 'url' => ['/refer/aepro']],
                        ['label' => 'รายงานหน่วยบริการปลายทางที่ให้บริการฉุกเฉินข้ามเขต', 'url' => ['/refer/aehcode']],
                        ['label' => 'รายงาน DRG. ที่มีการส่งต่อไปนอกเขต', 'url' => ['/refer/drg']],
                        ['label' => 'รายงาน PDX. ที่มีการส่งต่อไปนอกเขต', 'url' => ['/refer/pdx']],
                        ['label' => 'จำนวนครั้งของการส่งต่อไปรักษานอกเขต รายจังหวัด/สถานบริการ', 'url' => ['/refer/hmainpro']],
                    ]],
               ['label' => 'CMI', 'items' => [
                        ['label' => 'ข้อมูล CMI รายจังหวัด/สถานบริการ', 'url' => ['/cmi']],
                        ['label' => 'ข้อมูล CMI ตามประเภทสถานบริการ', 'url' => ['/cmi/htype']],
                    ]],
                ['label' => 'ข้อมูลบริการโรคเฉพาะ', 'active' => true, 'items' => [
                        ['label' => 'ข้อมูลบริการโรคเฉพาะ PCI', 'items' => [
                                ['label' => 'การให้บริการผู้ป่วย PCI', 'url' => ['/spdrg']],
                                ['label' => 'รายงานการให้บริการโรคเฉพาะ PCI แยกตามกองทุน', 'url' => ['/spdrg/fund']],
                                ['label' => 'รายงานประเภทการไปรับบริการนอกเขตของผู้ป่วย PCI', 'url' => ['/spdrg/typeservice']],
                                ['label' => 'หน่วยบริการในเขตที่ให้บริการผู้ป่วยPCI ', 'url' => ['/spdrg/inregionpci']],
                                ['label' => 'หน่วยบริการนอกเขตที่ให้บริการผู้ป่วยPCI  ', 'url' => ['/spdrg/hmainpci']],
                            ]],
                        '<li class="divider"></li>',
                        ['label' => 'ข้อมูลบริการโรคเฉพาะ ข้อเข่า', 'items' => [
                                ['label' => 'การให้บริการผู้ป่วย ข้อเข่า', 'url' => ['/knee']],
                                ['label' => 'รายงานการให้บริการโรคเฉพาะ ข้อเข่า แยกตามกองทุน', 'url' => ['/knee/fund']],
                                ['label' => 'รายงานประเภทการไปรับบริการนอกเขตของผู้ป่วย ข้อเข่า', 'url' => ['/knee/typeservice']],
                                ['label' => 'หน่วยบริการในเขตที่ให้บริการผู้ป่วยข้อเข่า ', 'url' => ['/knee/inregion']],
                                ['label' => 'หน่วยบริการนอกเขตที่ให้บริการผู้ป่วยข้อเข่า  ', 'url' => ['/knee/hmain']],
                            ]],
                    ]],
                 
            ];

            echo NavX::widget([
                'options' => ['class' => 'navbar-nav'],
                //'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
                'activateParents' => true,
                'encodeLabels' => false
            ]);
            NavBar::end();
            ?>

            <div class="container">
<?=
Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
])
?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; NHSO เขต 4 สระบุรี <?= date('Y') ?></p>

                <p class="pull-right"></p>
            </div>
        </footer>

<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

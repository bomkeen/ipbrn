<?php

namespace frontend\controllers;

use yii;
use common\models\MList;
use common\models\Hospital;
use common\models\Nhsozone;
use common\models\NhsozoneUpdate;

class IpdfundController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    public function actionIndex() {
        $n = [];
        $na = [];
        $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            if ($m1 == 10 OR $m1 == 11 OR $m1 == 12) {
                $dch1 = ((int) $y - 1) . "" . $m1;
            } else {
                $dch1 = $y . $m1;
            }
            if ($m2 == 10 OR $m2 == 11 OR $m2 == 12) {
                $dch2 = ((int) $y - 1) . "" . $m2;
            } else {
                $dch2 = $y . $m2;
            }
        }
        $sql = "SELECT 
sl.REGIONCODE,sl.HCODE,sl.HCODEDESCR,sl.PROV1,sl.PURPROVDESCR
,sl.DATEDSC
,sl.DATEDSC_MONTH
,SUM(CASE WHEN sl.FUNDCODE='IPINRGR' THEN sl.n ELSE 0 END) as IPINRGR
,SUM(CASE WHEN sl.FUNDCODE='IPAER' THEN sl.n ELSE 0 END) as IPAER
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN sl.n ELSE 0 END) as IPAEC
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN sl.n ELSE 0 END) as IPINRGC
,SUM(CASE WHEN sl.FUNDCODE='IPNB' THEN sl.n ELSE 0 END) as IPNB
,SUM(CASE WHEN sl.FUNDCODE='CATARACT' THEN sl.n ELSE 0 END) as CATARACT
,SUM(CASE WHEN sl.FUNDCODE='IPPUC' THEN sl.n ELSE 0 END) as IPPUC
,SUM(CASE WHEN sl.FUNDCODE is not null THEN sl.n ELSE 0 END) as N
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_ipd_fund_hcode sl
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
    and sl.FUNDCODE in ('IPINRGR','IPNB','IPAER','IPAEC','CATARACT','IPINRGC','IPPUC')
GROUP BY sl.PROV1";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);

        ////////////////Chart//////////
        $sqlchart = "SELECT SUM(n) as n,FUNDCODE from rs_ipd_fund_hcode
 WHERE DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
     and FUNDCODE in ('IPINRGR','IPNB','IPAER','IPAEC','CATARACT','IPINRGC','IPPUC')
 GROUP BY FUNDCODE";
        $rschart = \Yii::$app->db->createCommand("$sqlchart")->queryAll();
        foreach ($rschart as $d) {
            array_push($n, intval($d['n']));
            array_push($na, $d['FUNDCODE']);
        }
        ////////////////////////////////
        $m_list = MList::find()->all();
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'n' => $n,
                    'na' => $na,
                    'y' => $y,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'm_list' => $m_list,
                    'm1' => $m1,
                    'm2' => $m2
        ]);
    }

    public function action7fundhcode($m1, $m2, $y, $dch1, $dch2, $prov1) {
        $n = [];
        $na = [];
        //$y=  $y;
        //$dch1=((int)$y - 1).'10';
        // $dch2=$y.'09';
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            $prov1 = $request->post('prov1');
            if ($m1 == 10 OR $m1 == 11 OR $m1 == 12) {
                $dch1 = ((int) $y - 1) . "" . $m1;
            } else {
                $dch1 = $y . $m1;
            }
            if ($m2 == 10 OR $m2 == 11 OR $m2 == 12) {
                $dch2 = ((int) $y - 1) . "" . $m2;
            } else {
                $dch2 = $y . $m2;
            }
        }

        $sql = "SELECT 
sl.REGIONCODE,sl.HCODE,sl.HCODEDESCR,sl.PROV1,sl.PURPROVDESCR
,sl.DATEDSC
,sl.DATEDSC_MONTH
,SUM(CASE WHEN sl.FUNDCODE='IPINRGR' THEN sl.n ELSE 0 END) as IPINRGR
,SUM(CASE WHEN sl.FUNDCODE='IPAER' THEN sl.n ELSE 0 END) as IPAER
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN sl.n ELSE 0 END) as IPAEC
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN sl.n ELSE 0 END) as IPINRGC
,SUM(CASE WHEN sl.FUNDCODE='IPNB' THEN sl.n ELSE 0 END) as IPNB
,SUM(CASE WHEN sl.FUNDCODE='CATARACT' THEN sl.n ELSE 0 END) as CATARACT
,SUM(CASE WHEN sl.FUNDCODE='IPPUC' THEN sl.n ELSE 0 END) as IPPUC
,SUM(CASE WHEN sl.FUNDCODE is not null THEN sl.n ELSE 0 END) as N
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_ipd_fund_hcode sl
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
    and sl.FUNDCODE in ('IPINRGR','IPNB','IPAER','IPAEC','CATARACT','IPINRGC','IPPUC')
AND  sl.PROV1 =$prov1 
GROUP BY sl.HCODE";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        ////////////////Chart//////////
        $sqlchart = "SELECT SUM(n) as n,FUNDCODE from rs_ipd_fund_hcode
 WHERE DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' and PROV1 =$prov1  
     and FUNDCODE in ('IPINRGR','IPINRGC','IPAER','IPAEC')
 GROUP BY FUNDCODE";
        $rschart = \Yii::$app->db->createCommand("$sqlchart")->queryAll();
        foreach ($rschart as $d) {
            array_push($n, intval($d['n']));
            array_push($na, $d['FUNDCODE']);
        }
        ////////////////////////////////
        $m_list = MList::find()->all();
        $p_list = NhsozoneUpdate::find()->where(['NHSO_ZONE' => 04])->groupBy('PROVINCE_ID')->all();
        $p_name = \Yii::$app->db->createCommand("SELECT PROVINCE_NAME FROM nhsozone_update WHERE PROVINCE_ID=$prov1 GROUP BY PROVINCE_ID")->queryAll();
        return $this->render('7fund_hcode', [
                    'dataProvider' => $dataProvider,
                    'n' => $n,
                    'na' => $na,
                    'y' => $y,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'p_name' => $p_name,
                    //'PURPROVDESCR' => $PURPROVDESCR,
                    'm_list' => $m_list,
                    'p_list' => $p_list,
                    'prov1' => $prov1,
                    'm1' => $m1,
                    'm2' => $m2
        ]);
    }

    public function actionIpdsumfund() {
        $n = [];
        $na = [];
        $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            if ($m1 == 10 OR $m1 == 11 OR $m1 == 12) {
                $dch1 = ((int) $y - 1) . "" . $m1;
            } else {
                $dch1 = $y . $m1;
            }
            if ($m2 == 10 OR $m2 == 11 OR $m2 == 12) {
                $dch2 = ((int) $y - 1) . "" . $m2;
            } else {
                $dch2 = $y . $m2;
            }
        }

        $sql = "SELECT 
sl.REGIONCODE,sl.HCODE,sl.HCODEDESCR,sl.PROV1,sl.PURPROVDESCR
,sl.DATEDSC
,sl.DATEDSC_MONTH
,SUM(CASE WHEN sl.FUNDCODE='IPINRGR' THEN sl.n ELSE 0 END) as IPINRGR
,SUM(CASE WHEN sl.FUNDCODE='IPAER' THEN sl.n ELSE 0 END) as IPAER
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN sl.n ELSE 0 END) as IPAEC
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN sl.n ELSE 0 END) as IPINRGC
,SUM(CASE WHEN sl.FUNDCODE is not null THEN sl.n ELSE 0 END) as N
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_ipd_fund_hcode sl
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
    and sl.FUNDCODE in ('IPINRGR','IPINRGC','IPAER','IPAEC')
GROUP BY sl.PROV1";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);

        ////////////////Chart//////////
        $sqlchart = "SELECT SUM(n) as n,FUNDCODE from rs_ipd_fund_hcode
 WHERE DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
     and FUNDCODE in ('IPINRGR','IPINRGC','IPAER','IPAEC')
 GROUP BY FUNDCODE";
        $rschart = \Yii::$app->db->createCommand("$sqlchart")->queryAll();
        foreach ($rschart as $d) {
            array_push($n, intval($d['n']));
            array_push($na, $d['FUNDCODE']);
        }
        ////////////////////////////////
        $m_list = MList::find()->all();
        return $this->render('ipd_sum_fund_hcode_pro', [
                    'dataProvider' => $dataProvider,
                    'n' => $n,
                    'na' => $na,
                    'y' => $y,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'm_list' => $m_list,
                    'm1' => $m1,
                    'm2' => $m2
        ]);
    }

    public function actionIpdsumfundhcode($m1,$m2,$y, $dch1, $dch2, $prov1) {
        $n = [];
        $na = [];
        //$y=  $y;
        //$dch1=((int)$y - 1).'10';
        // $dch2=$y.'09';
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            $prov1 = $request->post('prov1');
            if ($m1 == 10 OR $m1 == 11 OR $m1 == 12) {
                $dch1 = ((int) $y - 1) . "" . $m1;
            } else {
                $dch1 = $y . $m1;
            }
            if ($m2 == 10 OR $m2 == 11 OR $m2 == 12) {
                $dch2 = ((int) $y - 1) . "" . $m2;
            } else {
                $dch2 = $y . $m2;
            }
        }

        $sql = "SELECT 
sl.REGIONCODE,sl.HCODE,sl.HCODEDESCR,sl.PROV1,sl.PURPROVDESCR
,sl.DATEDSC
,sl.DATEDSC_MONTH
,SUM(CASE WHEN sl.FUNDCODE='IPINRGR' THEN sl.n ELSE 0 END) as IPINRGR
,SUM(CASE WHEN sl.FUNDCODE='IPAER' THEN sl.n ELSE 0 END) as IPAER
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN sl.n ELSE 0 END) as IPAEC
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN sl.n ELSE 0 END) as IPINRGC
,SUM(CASE WHEN sl.FUNDCODE is not null THEN sl.n ELSE 0 END) as N
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_ipd_fund_hcode sl
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
    and sl.FUNDCODE in ('IPINRGR','IPINRGC','IPAER','IPAEC')
AND  sl.PROV1 =$prov1 
GROUP BY sl.HCODE";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        ////////////////Chart//////////
        $sqlchart = "SELECT SUM(n) as n,FUNDCODE from rs_ipd_fund_hcode
 WHERE DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' and PROV1 =$prov1  
     and FUNDCODE in ('IPINRGR','IPINRGC','IPAER','IPAEC')
 GROUP BY FUNDCODE";
        $rschart = \Yii::$app->db->createCommand("$sqlchart")->queryAll();
        foreach ($rschart as $d) {
            array_push($n, intval($d['n']));
            array_push($na, $d['FUNDCODE']);
        }
        ////////////////////////////////
        $m_list = MList::find()->all();
        $p_list = NhsozoneUpdate::find()->where(['NHSO_ZONE' => 04])->groupBy('PROVINCE_ID')->all();
        $p_name = \Yii::$app->db->createCommand("SELECT PROVINCE_NAME FROM nhsozone_update WHERE PROVINCE_ID=$prov1 GROUP BY PROVINCE_ID")->queryAll();
        return $this->render('ipd_sum_fund_hcode_hcode', [
                    'dataProvider' => $dataProvider,
                    'n' => $n,
                    'na' => $na,
                    'y' => $y,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'm_list' => $m_list,
            'p_name' => $p_name,
                    'p_list' => $p_list,
                    'prov1' => $prov1,
                    'm1' => $m1,
                    'm2' => $m2
        ]);
    }

    ///////////////////////////////////////////////
    /////////////////////////////////////////////
    //////////////////////////////////////////////
    //   HMAIN///////////////////////////////
    
     public function actionHmainregion() {
        $n = [];
        $na = [];
        $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            if ($m1 == 10 OR $m1 == 11 OR $m1 == 12) {
                $dch1 = ((int) $y - 1) . "" . $m1;
            } else {
                $dch1 = $y . $m1;
            }
            if ($m2 == 10 OR $m2 == 11 OR $m2 == 12) {
                $dch2 = ((int) $y - 1) . "" . $m2;
            } else {
                $dch2 = $y . $m2;
            }
        }

        $sql = "SELECT 
sl.REGIONCODE,r.region_name as REGION_NAME,sl.HCODE,sl.HCODEDESCR,sl.PROV1,sl.PURPROVDESCR
,sl.DATEDSC
,sl.DATEDSC_MONTH
,SUM(CASE WHEN sl.FUNDCODE='IPINRGR' THEN sl.n ELSE 0 END) as IPINRGR
,SUM(CASE WHEN sl.FUNDCODE='IPAER' THEN sl.n ELSE 0 END) as IPAER
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN sl.n ELSE 0 END) as IPAEC
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN sl.n ELSE 0 END) as IPINRGC
,SUM(CASE WHEN sl.FUNDCODE is not null THEN sl.n ELSE 0 END) as N
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_ipd_fund_hmain sl
JOIN region_zone r on sl.REGIONCODE=r.region_code
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
    and sl.FUNDCODE in ('IPINRGR','IPINRGC','IPAER','IPAEC')
GROUP BY sl.REGIONCODE";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);

        ////////////////Chart//////////
        $sqlchart = "SELECT SUM(n) as n,FUNDCODE from rs_ipd_fund_hcode
 WHERE DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
     and FUNDCODE in ('IPINRGR','IPINRGC','IPAER','IPAEC')
 GROUP BY FUNDCODE";
        $rschart = \Yii::$app->db->createCommand("$sqlchart")->queryAll();
        foreach ($rschart as $d) {
            array_push($n, intval($d['n']));
            array_push($na, $d['FUNDCODE']);
        }
        ////////////////////////////////
        $m_list = MList::find()->all();
        return $this->render('hmain_region', [
                    'dataProvider' => $dataProvider,
                    'n' => $n,
                    'na' => $na,
                    'y' => $y,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'm_list' => $m_list,
                    'm1' => $m1,
                    'm2' => $m2
        ]);
    }
public function actionHmainpro($m1,$m2,$y, $dch1, $dch2, $region) {
        $n = [];
        $na = [];
        $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            $region = $request->post('region');
            if ($m1 == 10 OR $m1 == 11 OR $m1 == 12) {
                $dch1 = ((int) $y - 1) . "" . $m1;
            } else {
                $dch1 = $y . $m1;
            }
            if ($m2 == 10 OR $m2 == 11 OR $m2 == 12) {
                $dch2 = ((int) $y - 1) . "" . $m2;
            } else {
                $dch2 = $y . $m2;
            }
        }

        $sql = "SELECT 
sl.REGIONCODE,r.region_name as REGION_NAME,sl.HCODE,sl.HCODEDESCR,sl.PROV1,sl.PURPROVDESCR
,sl.DATEDSC
,sl.DATEDSC_MONTH
,SUM(CASE WHEN sl.FUNDCODE='IPINRGR' THEN sl.n ELSE 0 END) as IPINRGR
,SUM(CASE WHEN sl.FUNDCODE='IPAER' THEN sl.n ELSE 0 END) as IPAER
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN sl.n ELSE 0 END) as IPAEC
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN sl.n ELSE 0 END) as IPINRGC
,SUM(CASE WHEN sl.FUNDCODE is not null THEN sl.n ELSE 0 END) as N
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_ipd_fund_hmain sl
JOIN region_zone r on sl.REGIONCODE=r.region_code
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
    and sl.FUNDCODE in ('IPINRGR','IPINRGC','IPAER','IPAEC')
    and sl.REGIONCODE=$region
GROUP BY sl.PROV1";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        $region_list= \Yii::$app->db->createCommand("SELECT region_code,region_name FROM region_zone WHERE region_code <> 4")->queryAll();
        $region_name=\Yii::$app->db->createCommand("SELECT region_name FROM region_zone WHERE region_code=$region")->queryAll();
        return $this->render('hmain_pro', [
                    'dataProvider' => $dataProvider,
                    'n' => $n,
                    'na' => $na,
                    'y' => $y,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
            'region_list'=>$region_list,
            'region_name'=>$region_name,
            'region'=>$region,
                    'm_list' => $m_list,
                    'm1' => $m1,
                    'm2' => $m2
        ]);
    }

    public function actionHmainhcode($m1,$m2,$y, $dch1, $dch2, $prov1,$region) {
        $n = [];
        $na = [];
        $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            $prov1 = $request->post('prov1');
            if ($m1 == 10 OR $m1 == 11 OR $m1 == 12) {
                $dch1 = ((int) $y - 1) . "" . $m1;
            } else {
                $dch1 = $y . $m1;
            }
            if ($m2 == 10 OR $m2 == 11 OR $m2 == 12) {
                $dch2 = ((int) $y - 1) . "" . $m2;
            } else {
                $dch2 = $y . $m2;
            }
        }

        $sql = "SELECT 
sl.REGIONCODE,r.region_name as REGION_NAME,sl.HCODE,sl.HCODEDESCR,sl.PROV1,sl.PURPROVDESCR
,sl.DATEDSC
,sl.DATEDSC_MONTH
,SUM(CASE WHEN sl.FUNDCODE='IPINRGR' THEN sl.n ELSE 0 END) as IPINRGR
,SUM(CASE WHEN sl.FUNDCODE='IPAER' THEN sl.n ELSE 0 END) as IPAER
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN sl.n ELSE 0 END) as IPAEC
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN sl.n ELSE 0 END) as IPINRGC
,SUM(CASE WHEN sl.FUNDCODE is not null THEN sl.n ELSE 0 END) as N
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_ipd_fund_hmain sl
JOIN region_zone r on sl.REGIONCODE=r.region_code
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
    and sl.FUNDCODE in ('IPINRGR','IPINRGC','IPAER','IPAEC')
    and sl.PROV1=$prov1
GROUP BY sl.HCODE";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        $p_name = \Yii::$app->db->createCommand("SELECT PROVINCE_NAME FROM nhsozone_update WHERE PROVINCE_ID=$prov1 GROUP BY PROVINCE_ID")->queryAll();
$p_list = \Yii::$app->db->createCommand("SELECT * FROM nhsozone_update WHERE NHSO_ZONE = $region GROUP BY PROVINCE_ID")->queryAll();
        return $this->render('hmain_hcode', [
                    'dataProvider' => $dataProvider,
                    'n' => $n,
                    'na' => $na,
                    'y' => $y,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
            'p_list'=>$p_list,
            'p_name'=>$p_name,
            'prov1'=>$prov1,
                   'm_list' => $m_list,
                    'm1' => $m1,
                    'm2' => $m2
        ]);
    }

     
}

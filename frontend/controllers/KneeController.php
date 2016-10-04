<?php

namespace frontend\controllers;

use yii;
use common\models\MList;
use common\models\Fundlist;
use common\models\NhsozoneUpdate;

class KneeController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    public function actionIndex() {
        $sql="SELECT COUNT(SERVKEY) as n
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN 1 ELSE 0 END) as IPAEC
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN 1 ELSE 0 END) as IPINRGC
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN 1 ELSE 0 END) as IPAER
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN 1 ELSE 0 END) as IPINRGR
,CONCAT('ปีงบประมาณ',' ',sl.GYEAR) as GYEAR 
FROM rs_knee as sl 
WHERE sl.HMAINREGIONCODE=4
GROUP BY sl.GYEAR";
            $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
             $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        return $this->render('index',[
            'dataProvider'=>$dataProvider           
        ]);
    }

    public function actionKnee() {
        $n = [];
        $na = [];
        $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
        $prov1 = 1200;
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
        $sql = "SELECT COUNT(*) as n,concat(FUNDCODE,' ',FUNDNAME) as FUND 
FROM rs_knee as sl WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' 
GROUP BY FUNDCODE";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        foreach ($rs as $d) {
            array_push($n, intval($d['n']));
            array_push($na, $d['FUND']);
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        return $this->render('knee', [
                    'n' => $n,
                    'na' => $na,
                    'y' => $y,
                    'm_list' => $m_list,
                    'm1' => $m1,
                    'm2' => $m2,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFund() {
        //$n = [];
        //$na = [];
        $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
        //$fund = 'IPINRGR';
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            $fund = $request->post('fund');
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
        $sql = "SELECT sl.PROVDESCR as pro,sl.PROV2
,SUM(CASE WHEN sl.FUNDCODE='IPINRGR' THEN 1 ELSE 0 END) as IPINRGR
,SUM(CASE WHEN sl.FUNDCODE='IPAER' THEN 1 ELSE 0 END) as IPAER
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN 1 ELSE 0 END) as IPAEC
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN 1 ELSE 0 END) as IPINRGC
,SUM(CASE WHEN sl.FUNDCODE is not null THEN 1 ELSE 0 END) as N
FROM rs_knee as sl WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.HMAINREGIONCODE=04 
GROUP BY PROV2";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
//        foreach ($rs as $d) {
//            array_push($n, intval($d['n']));
//            array_push($na, $d['pro']);
//        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        //$fundlist = Fundlist::find()->all();
        return $this->render('fund', [
                    //'n' => $n,
                    //'na' => $na,
                    'y' => $y,
                    'm_list' => $m_list,
                    //'fundlist' => $fundlist,
                    //'fund' => $fund,
                    'm1' => $m1,
                    'm2' => $m2,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFundhcode($m1, $m2, $y, $dch1, $dch2, $prov2) {
        $n = [];
        $na = [];
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            $prov2 = $request->post('prov2');
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
        $sql = "SELECT sl.HMAINDESCR
,SUM(CASE WHEN sl.FUNDCODE='IPINRGR' THEN 1 ELSE 0 END) as IPINRGR
,SUM(CASE WHEN sl.FUNDCODE='IPAER' THEN 1 ELSE 0 END) as IPAER
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN 1 ELSE 0 END) as IPAEC
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN 1 ELSE 0 END) as IPINRGC
,SUM(CASE WHEN sl.FUNDCODE is not null THEN 1 ELSE 0 END) as N
FROM rs_knee as sl WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.HMAINREGIONCODE=04 AND PROV2=$prov2
GROUP BY HMAIN2";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        $p_list = NhsozoneUpdate::find()->where(['NHSO_ZONE' => 04])->groupBy('PROVINCE_ID')->all();
        $p_name = \Yii::$app->db->createCommand("SELECT PROVINCE_NAME FROM nhsozone_update WHERE PROVINCE_ID=$prov2 GROUP BY PROVINCE_ID")->queryAll();
        return $this->render('fund_hcode', [
                    'dataProvider' => $dataProvider,
                    'y' => $y,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'm_list' => $m_list,
                    'p_name' => $p_name,
                    'p_list' => $p_list,
                    'prov2' => $prov2,
                    'm1' => $m1,
                    'm2' => $m2
        ]);
    }

    public function actionTypeservice() {

        $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
        //$fund = 'IPINRGR';
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            $fund = $request->post('fund');
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
        $sql = "SELECT sl.PROVDESCR as pro,sl.PROV2
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN 1 ELSE 0 END) as IPAEC
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN sl.NETGLOBPAIDAMT ELSE 0 END) as IPAEC_NET
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN 1 ELSE 0 END) as IPINRGC
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN sl.NETGLOBPAIDAMT ELSE 0 END) as IPINRGC_NET
,SUM(CASE WHEN sl.FUNDCODE is not null THEN 1 ELSE 0 END) as N
,SUM(CASE WHEN sl.FUNDCODE is not null THEN sl.NETGLOBPAIDAMT ELSE 0 END) as NET
FROM rs_knee as sl WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.HMAINREGIONCODE=04 AND REGIONCODE<>04 AND sl.FUNDCODE in ('IPAEC','IPINRGC')
GROUP BY PROV2";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $g1 = \Yii::$app->db->createCommand("SELECT COUNT(DISTINCT sl.SERVKEY) as n ,sl.FUNDCODE as fund
FROM rs_knee as sl WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND sl.HMAINREGIONCODE=04  AND sl.FUNDCODE in ('IPAEC','IPINRGC')
GROUP BY FUNDCODE")->queryAll();
        $g2 = \Yii::$app->db->createCommand("SELECT SUM(sl.NETGLOBPAIDAMT) as n ,sl.FUNDCODE as fund
FROM rs_knee as sl WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND sl.HMAINREGIONCODE=04  AND sl.FUNDCODE in ('IPAEC','IPINRGC')
GROUP BY FUNDCODE")->queryAll();
        $n = [];
        $na = [];
        foreach ($g1 as $d) {
            array_push($n, intval($d['n']));
            array_push($na, $d['fund']);
        }
        $n2 = [];
        $na2 = [];
        foreach ($g2 as $d) {
            array_push($n2, intval($d['n']));
            array_push($na2, $d['fund']);
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        //$fundlist = Fundlist::find()->all();
        return $this->render('type_service', [
                    'n' => $n, 'na' => $na, 'n2' => $n2, 'na2' => $na2,
                    'y' => $y, 'm_list' => $m_list, 'm1' => $m1, 'm2' => $m2,
                    'dch1' => $dch1, 'dch2' => $dch2,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTypeservicehcode($m1, $m2, $y, $dch1, $dch2, $prov2) {

        $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
//$prov2=1200;
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            $prov2 = $request->post('prov2');
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
        $sql = "SELECT HMAINDESCR,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN 1 ELSE 0 END) as IPAEC
,SUM(CASE WHEN sl.FUNDCODE='IPAEC' THEN sl.NETGLOBPAIDAMT ELSE 0 END) as IPAEC_NET
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN 1 ELSE 0 END) as IPINRGC
,SUM(CASE WHEN sl.FUNDCODE='IPINRGC' THEN sl.NETGLOBPAIDAMT ELSE 0 END) as IPINRGC_NET
,SUM(CASE WHEN sl.FUNDCODE is not null THEN 1 ELSE 0 END) as N
,SUM(CASE WHEN sl.FUNDCODE is not null THEN sl.NETGLOBPAIDAMT ELSE 0 END) as NET
FROM rs_knee as sl WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.PROV2=$prov2 AND sl.HMAINREGIONCODE=04 AND REGIONCODE<>04 AND sl.FUNDCODE in ('IPAEC','IPINRGC')
GROUP BY HMAIN2";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        $p_list = NhsozoneUpdate::find()->where(['NHSO_ZONE' => 04])->groupBy('PROVINCE_ID')->all();
        $p_name = \Yii::$app->db->createCommand("SELECT PROVINCE_NAME FROM nhsozone_update WHERE PROVINCE_ID=$prov2 GROUP BY PROVINCE_ID")->queryAll();
        return $this->render('type_service_hcode', [
                    'y' => $y, 'm_list' => $m_list, 'm1' => $m1, 'm2' => $m2,
                    'dch1' => $dch1, 'dch2' => $dch2, 'prov2' => $prov2,
                    'dataProvider' => $dataProvider,
                    'p_list' => $p_list, 'p_name' => $p_name
        ]);
    }

    public function actionInregion() {
        
        $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
        //$fund = 'IPINRGR';
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            $fund = $request->post('fund');
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
        $sql = "SELECT sl.HCODEDESCR as hname
,COUNT(DISTINCT sl.SERVKEY) as N,SUM(sl.NETGLOBPAIDAMT) as NET FROM rs_knee as sl 
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.REGIONCODE=04  
GROUP BY HCODE ORDER BY COUNT(DISTINCT sl.SERVKEY) DESC ";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $g = \Yii::$app->db->createCommand("SELECT sl.HCODEDESCR as hname
,COUNT(DISTINCT sl.SERVKEY) as N FROM rs_knee as sl 
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.REGIONCODE=04  
GROUP BY HCODE ORDER BY COUNT(DISTINCT sl.SERVKEY) DESC limit 10")->queryAll();
        $n = [];
        $na = [];
        foreach ($g as $d) {
            array_push($n, (int)($d['N']));
            array_push($na,$d['hname']);
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        //$fundlist = Fundlist::find()->all();
        return $this->render('inregion', [
                    'n' => $n,'na' => $na,
                    'y' => $y,
                    'm_list' => $m_list,
                    'm1' => $m1,
                    'm2' => $m2,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'dataProvider' => $dataProvider,
        ]);
    }
     public function actionHmain() {
        
        $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
        //$fund = 'IPINRGR';
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            $fund = $request->post('fund');
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
        $sql = "SELECT sl.HCODEDESCR as hname
,COUNT(DISTINCT sl.SERVKEY) as N,SUM(sl.NETGLOBPAIDAMT) as NET FROM rs_knee as sl 
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.REGIONCODE<>04 AND HMAINREGIONCODE=04  
GROUP BY HCODE ORDER BY COUNT(DISTINCT sl.SERVKEY) DESC ";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $g = \Yii::$app->db->createCommand("SELECT sl.HCODEDESCR as hname
,COUNT(DISTINCT sl.SERVKEY) as N,SUM(sl.NETGLOBPAIDAMT) as NET FROM rs_knee as sl 
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.REGIONCODE<>04 AND HMAINREGIONCODE=04  
GROUP BY HCODE ORDER BY COUNT(DISTINCT sl.SERVKEY) DESC limit 10")->queryAll();
        $n = [];
        $na = [];
        foreach ($g as $d) {
            array_push($n, (int)($d['N']));
            array_push($na,$d['hname']);
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        //$fundlist = Fundlist::find()->all();
        return $this->render('hmain', [
                    'n' => $n,'na' => $na,
                    'y' => $y,
                    'm_list' => $m_list,
                    'm1' => $m1,
                    'm2' => $m2,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'dataProvider' => $dataProvider,
        ]);
    }
}

<?php

namespace frontend\controllers;
use common\models\MList;
use common\models\NhsozoneUpdate;
use yii;
class ChkController extends \yii\web\Controller
{
     public $enableCsrfValidation = false;
    public function actionIndex()
    {
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
        $sql = "SELECT sl.PURPROVDESCR as pro,sl.PROV1
,SUM(CASE WHEN sl.PS_AF = 0 THEN  N ELSE 0 END) as not_late
,SUM(CASE WHEN sl.PS_AF = 1 THEN N ELSE 0 END) as 1month
,SUM(CASE WHEN sl.PS_AF = 2 THEN N ELSE 0 END) as 2month
,SUM(CASE WHEN sl.PS_AF = 3 THEN N ELSE 0 END) as 3month
,SUM(CASE WHEN sl.PS_AF = 4 THEN N ELSE 0 END) as 4month
,SUM(CASE WHEN sl.PS_AF is not null THEN N ELSE 0 END) as N
FROM rs_ps_af as sl WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.REGIONCODE=4 
GROUP BY sl.PROV1";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        return $this->render('index', [
                   'y' => $y,'m_list' => $m_list,
                    'm1' => $m1,
                    'm2' => $m2,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'dataProvider' => $dataProvider,
        ]);
    }
public function actionChkhcode($m1, $m2, $y, $dch1, $dch2, $prov1) {
        $n = [];
        $na = [];
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
        $sql = "SELECT sl.HCODEDESCR ,sl.PROV1
,SUM(CASE WHEN sl.PS_AF = 0 THEN  N ELSE 0 END) as not_late
,SUM(CASE WHEN sl.PS_AF = 1 THEN N ELSE 0 END) as 1month
,SUM(CASE WHEN sl.PS_AF = 2 THEN N ELSE 0 END) as 2month
,SUM(CASE WHEN sl.PS_AF = 3 THEN N ELSE 0 END) as 3month
,SUM(CASE WHEN sl.PS_AF = 4 THEN N ELSE 0 END) as 4month
,SUM(CASE WHEN sl.PS_AF is not null THEN N ELSE 0 END) as N
FROM rs_ps_af as sl WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.REGIONCODE=4 AND sl.PROV1=$prov1 
GROUP BY sl.HCODE";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        $p_list = NhsozoneUpdate::find()->where(['NHSO_ZONE' => 04])->groupBy('PROVINCE_ID')->all();
        $p_name = \Yii::$app->db->createCommand("SELECT PROVINCE_NAME FROM nhsozone_update WHERE PROVINCE_ID=$prov1 GROUP BY PROVINCE_ID")->queryAll();
        return $this->render('chkhcode', [
                    'dataProvider' => $dataProvider,
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
    public function actionSt()
    {
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
        $sql = "SELECT sl.PURPROVDESCR as pro,sl.PROV1
,SUM(CASE WHEN sl.`STATUS` = 0 THEN  N ELSE 0 END) as s0
,SUM(CASE WHEN sl.`STATUS` = 1 THEN  N ELSE 0 END) as s1
,SUM(CASE WHEN sl.`STATUS` = 2 THEN  N ELSE 0 END) as s2
,SUM(CASE WHEN sl.`STATUS` = 3 THEN  N ELSE 0 END) as s3
,SUM(CASE WHEN sl.`STATUS` = 4 THEN  N ELSE 0 END) as s4
,SUM(CASE WHEN sl.`STATUS` = 5 THEN  N ELSE 0 END) as s5
,SUM(CASE WHEN sl.`STATUS` = 6 THEN  N ELSE 0 END) as s6
,SUM(CASE WHEN sl.`STATUS` = 7 THEN  N ELSE 0 END) as s7
,SUM(CASE WHEN sl.`STATUS` = 8 THEN  N ELSE 0 END) as s8
,SUM(CASE WHEN sl.`STATUS` = 9 THEN  N ELSE 0 END) as s9
,SUM(CASE WHEN sl.`STATUS` = 'Z' THEN  N ELSE 0 END) as sZ
,SUM(CASE WHEN sl.`STATUS` = 'Y' THEN  N ELSE 0 END) as sW 
,SUM(CASE WHEN sl.`STATUS` = 'X' THEN  N ELSE 0 END) as sX
,SUM(CASE WHEN sl.`STATUS` = 'W' THEN  N ELSE 0 END) as sW
,SUM(CASE WHEN sl.`STATUS` is not null THEN N ELSE 0 END) as N
FROM rs_status as sl WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.REGIONCODE=4 
GROUP BY sl.PROV1";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        return $this->render('st', [
                   'y' => $y,'m_list' => $m_list,
                    'm1' => $m1,
                    'm2' => $m2,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionSthcode($m1, $m2, $y, $dch1, $dch2, $prov1) {
        $n = [];
        $na = [];
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
        $sql = "SELECT sl.HCODEDESCR ,sl.PROV1
,SUM(CASE WHEN sl.`STATUS` = 0 THEN  N ELSE 0 END) as s0
,SUM(CASE WHEN sl.`STATUS` = 1 THEN  N ELSE 0 END) as s1
,SUM(CASE WHEN sl.`STATUS` = 2 THEN  N ELSE 0 END) as s2
,SUM(CASE WHEN sl.`STATUS` = 3 THEN  N ELSE 0 END) as s3
,SUM(CASE WHEN sl.`STATUS` = 4 THEN  N ELSE 0 END) as s4
,SUM(CASE WHEN sl.`STATUS` = 5 THEN  N ELSE 0 END) as s5
,SUM(CASE WHEN sl.`STATUS` = 6 THEN  N ELSE 0 END) as s6
,SUM(CASE WHEN sl.`STATUS` = 7 THEN  N ELSE 0 END) as s7
,SUM(CASE WHEN sl.`STATUS` = 8 THEN  N ELSE 0 END) as s8
,SUM(CASE WHEN sl.`STATUS` = 9 THEN  N ELSE 0 END) as s9
,SUM(CASE WHEN sl.`STATUS` = 'Z' THEN  N ELSE 0 END) as sZ
,SUM(CASE WHEN sl.`STATUS` = 'Y' THEN  N ELSE 0 END) as sW 
,SUM(CASE WHEN sl.`STATUS` = 'X' THEN  N ELSE 0 END) as sX
,SUM(CASE WHEN sl.`STATUS` = 'W' THEN  N ELSE 0 END) as sW
,SUM(CASE WHEN sl.`STATUS` is not null THEN N ELSE 0 END) as N
FROM rs_status as sl WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.REGIONCODE=4 AND sl.PROV1=$prov1 
GROUP BY sl.HCODE";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        $p_list = NhsozoneUpdate::find()->where(['NHSO_ZONE' => 04])->groupBy('PROVINCE_ID')->all();
        $p_name = \Yii::$app->db->createCommand("SELECT PROVINCE_NAME FROM nhsozone_update WHERE PROVINCE_ID=$prov1 GROUP BY PROVINCE_ID")->queryAll();
        return $this->render('sthcode', [
                    'dataProvider' => $dataProvider,
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
}

<?php

namespace frontend\controllers;

use yii;
use common\models\MList;
use common\models\Hospital;
use common\models\Nhsozone;

class CmiController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    public function actionIndex() {
        $n = [];
        $na = [];
        $nn = [];
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
        $sql = "SELECT 
TRUNCATE((SUM(ADJRW)/SUM(n)),2) as cmi,CONCAT('ปีงบประมาณ',' ',GYEAR) as yname
FROM rs_ipd_fund_hcode GROUP BY  GYEAR";
        $sqllist = "SELECT 
SUM(ADJRW)/SUM(n)as cmi,PURPROVDESCR,PROV1
FROM rs_ipd_fund_hcode 
WHERE   DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
GROUP BY  PROV1";

        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $rs_list = \Yii::$app->db->createCommand("$sqllist")->queryAll();
        $rs_provider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs_list,
            'pagination' => FALSE,
        ]);
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        return $this->render('index', [
                    'n' => $n,
                    'na' => $na,
                    'nn' => $nn,
                    'y' => $y,
                    'm1' => $m1,
                    'm2' => $m2,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'm_list' => $m_list,
                    'dataProvider' => $dataProvider,
                    'rs_provider' => $rs_provider
        ]);
    }

    public function actionPro($m1, $m2, $y, $dch1, $dch2, $prov1) {
        $n = [];
        $na = [];
        $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
        //$prov1 = 1200;
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
SUM(ADJRW)/SUM(n)as cmi,HCODEDESCR
FROM rs_ipd_fund_hcode 
WHERE  PROV1=$prov1 AND DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
GROUP BY  HCODE";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);


        $m_list = MList::find()->all();
        $p_list = \Yii::$app->db->createCommand("SELECT PROVINCE_ID,PROVINCE_NAME from nhsozone_update  WHERE NHSO_ZONE=4")->queryAll();
        $p_name = \Yii::$app->db->createCommand("SELECT PROVINCE_NAME FROM nhsozone_update WHERE PROVINCE_ID=$prov1 GROUP BY PROVINCE_ID")->queryAll();
        return $this->render('pro', [
                    'dataProvider' => $dataProvider,
                    'y' => $y,
                    'm1' => $m1,
                    'm2' => $m2,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'prov1' => $prov1,
                    'm_list' => $m_list,
                    'p_list' => $p_list,
                    'p_name' => $p_name
        ]);
    }

    public function actionHtype() {
        $n = [];
        $na = [];
        $nn = [];
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

        $sqllist = "SELECT 
TRUNCATE((SUM(ADJRW)/SUM(n)),2) as cmi,SUBTYPEDESCR,SUBTYPE
FROM rs_ipd_fund_hcode 
WHERE   DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
GROUP BY  SUBTYPE";

        // $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $rs_list = \Yii::$app->db->createCommand("$sqllist")->queryAll();
        $rs_provider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs_list,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        return $this->render('htype', [
                    'n' => $n,
                    'na' => $na,
                    'nn' => $nn,
                    'y' => $y,
                    'm1' => $m1,
                    'm2' => $m2,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'm_list' => $m_list,
                    //'dataProvider' => $dataProvider,
                    'rs_provider' => $rs_provider
        ]);
    }

    public function actionHtypepro($m1, $m2, $y, $dch1, $dch2, $subtype) {
        $n = [];
        $na = [];
        $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
        //$prov1 = 1200;
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            $subtype = $request->post('subtype');
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
SUM(ADJRW)/SUM(n)as cmi,HCODEDESCR
FROM rs_ipd_fund_hcode 
WHERE   DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND SUBTYPE=$subtype
GROUP BY  HCODE";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();

        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);


        $m_list = MList::find()->all();
        //$p_list = Nhsozone::find()->where(['NHSO_ZONE' => 04])->groupBy('PROVINCE_ID')->all();
        $t_list = \Yii::$app->db->createCommand("SELECT SUBTYPE,SUBTYPEDESCR FROM subtype")->queryAll();
        $t_name = \Yii::$app->db->createCommand("SELECT SUBTYPE,SUBTYPEDESCR FROM subtype WHERE SUBTYPE=$subtype")->queryAll();
        return $this->render('htype_pro', [
                    'dataProvider' => $dataProvider,
                    'y' => $y,
                    'm1' => $m1,
                    'm2' => $m2,
                    'dch1' => $dch1,
                    'dch2' => $dch2,
                    'subtype' => $subtype,
                    'm_list' => $m_list,
                    't_list' => $t_list,
                    't_name' => $t_name
        ]);
    }

}

<?php

namespace frontend\controllers;

use yii;
use common\models\MList;
use common\models\Hospital;
use common\models\Nhsozone;

class DrgController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    public function actionDrgregion() {
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
SUM(sl.N) as N,sl.REGIONCODE,sl.HCODE,sl.HCODEDESCR,sl.PROV1,sl.PURPROVDESCR
,sl.DATEDSC
,sl.DATEDSC_MONTH
,CONCAT(sl.DRG,' ',sl.DRGNAME) as DRG
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_drg_hcode sl
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' 
GROUP BY sl.DRG ORDER BY SUM(sl.N) DESC LIMIT 10";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $rschart = \Yii::$app->db->createCommand("$sql")->queryAll();
        foreach ($rschart as $d) {
            array_push($n, intval($d['N']));
            array_push($na, $d['DRG']);
        }
        ////////////////////////////////
        $m_list = MList::find()->all();
        return $this->render('drg_region', [
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

    public function actionDrgpro($m1, $m2, $y) {
        $pro = 0;
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

        $sql = "SELECT SUM(sl.N) as N,sl.REGIONCODE,sl.HCODE,sl.HCODEDESCR,sl.PROV1,sl.PURPROVDESCR
,sl.DATEDSC,sl.DATEDSC_MONTH
,CONCAT(sl.DRG,' ',sl.DRGNAME) as DRG
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_drg_hcode sl
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
    and sl.prov1=$prov1
GROUP BY sl.DRG ORDER BY SUM(sl.N) DESC LIMIT 10";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);

        $rschart = \Yii::$app->db->createCommand("$sql")->queryAll();
        foreach ($rschart as $d) {
            array_push($n, intval($d['N']));
            array_push($na, $d['DRG']);
        }

        ////////////////////////////////
        $m_list = MList::find()->all();
        //$p_list = Nhsozone::find()->where(['NHSO_ZONE' => 04])->groupBy('PROVINCE_ID')->all();
        $p_list = \Yii::$app->db->createCommand("SELECT PROVINCE_ID,PROVINCE_NAME from nhsozone_update  WHERE NHSO_ZONE=4")->queryAll();
        $p_name = \Yii::$app->db->createCommand("SELECT PROVINCE_NAME FROM nhsozone_update WHERE PROVINCE_ID=$prov1 GROUP BY PROVINCE_ID")->queryAll();
        return $this->render('drg_pro', [
                    'dataProvider' => $dataProvider,
                    'n' => $n,
                    'na' => $na,
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
////////////////////////////////////
    //////////////////////////////
    ////hmain
     public function actionHmain() {
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
SUM(sl.N) as N,sl.REGIONCODE,sl.HCODE,sl.HCODEDESCR,sl.PROV1,sl.PURPROVDESCR
,sl.DATEDSC
,sl.DATEDSC_MONTH
,CONCAT(sl.DRG,' ',sl.DRGNAME) as DRG
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_drg_hmain sl
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' 
GROUP BY sl.DRG ORDER BY SUM(sl.N) DESC LIMIT 10";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $rschart = \Yii::$app->db->createCommand("$sql")->queryAll();
        foreach ($rschart as $d) {
            array_push($n, intval($d['N']));
            array_push($na, $d['DRG']);
        }
        ////////////////////////////////
        $m_list = MList::find()->all();
        return $this->render('hmain', [
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
     public function actionRegion() {
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
SUM(sl.N) as N,sl.REGIONCODE,sl.HCODE,sl.HCODEDESCR,sl.PROV1,sl.PURPROVDESCR
,sl.DATEDSC
,sl.DATEDSC_MONTH
,CONCAT(sl.DRG,' ',sl.DRGNAME) as DRG
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_drg_hmain sl
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' 
GROUP BY sl.DRG ORDER BY SUM(sl.N) DESC LIMIT 10";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $rschart = \Yii::$app->db->createCommand("$sql")->queryAll();
        foreach ($rschart as $d) {
            array_push($n, intval($d['N']));
            array_push($na, $d['DRG']);
        }
        ////////////////////////////////
        $m_list = MList::find()->all();
        return $this->render('region', [
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
    public function actionHightcost() {
           $m1 = '10';
        $m2 = '09';
        $y = date('Y');
        $dch1 = ((int) $y - 1) . "" . $m1;
        $dch2 = $y . $m2;
        $fund = 'IPINRGC';
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $y = $request->post('year');
            $m1 = $request->post('m1');
            $m2 = $request->post('m2');
            $fund = $request->post('fund');
            //$prov1 = $request->post('prov1');
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
        $sql = "SELECT SUM(sl.SUMNET) as N ,CONCAT(sl.DRG,' ',sl.DRGNAME) as DRG
from rs_drg_hcode sl 
LEFT OUTER JOIN ccmi51drg c ON c.DRG=sl.drg
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND sl.FUNDCODE ='$fund' 
GROUP BY sl.DRG ORDER BY N DESC

";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $g = \Yii::$app->db->createCommand("SELECT SUM(sl.SUMNET) as N ,CONCAT(sl.DRG,' ',sl.DRGNAME) as DRG
from rs_drg_hcode sl 
LEFT OUTER JOIN ccmi51drg c ON c.DRG=sl.drg
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND sl.FUNDCODE ='$fund'
GROUP BY sl.DRG ORDER BY N DESC limit 10")->queryAll();
        $n = [];
        $na = [];
        foreach ($g as $d) {          
            array_push($n, (int)($d['N']));
            array_push($na,$d['DRG']);
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
           'pagination' => [
        'pageSize' => 10,
    ],
        ]);
        $m_list = MList::find()->all();
        $f_list = \Yii::$app->db->createCommand("SELECT FUNDCODE,FUNDNAME FROM fund")->queryAll();
        $f_name = \Yii::$app->db->createCommand("SELECT FUNDNAME FROM fund where FUNDCODE='$fund'")->queryAll();
        return $this->render('hightcost', [
                    'n' => $n,'na' => $na,
                    'y' => $y,
                    'm_list' => $m_list,'f_list'=>$f_list,'f_name'=>$f_name,
                    'm1' => $m1,'m2' => $m2,'fund'=>$fund,
                    'dch1' => $dch1,'dch2' => $dch2,
                    'dataProvider' => $dataProvider,
        ]);
      
        
    }
    
    
}

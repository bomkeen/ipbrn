<?php

namespace frontend\controllers;
use yii;
use common\models\MList;
use common\models\Hospital;
use common\models\Nhsozone;

class PdxController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }
 public function actionHcoderegion() {
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
,CONCAT(sl.pdx,' ',sl.DIAGNAME) as DIAG
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_pdx_hcode sl
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
GROUP BY sl.pdx ORDER BY SUM(sl.N) DESC LIMIT 10";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $rschart = \Yii::$app->db->createCommand("$sql")->queryAll();
        foreach ($rschart as $d) {
            array_push($n, intval($d['N']));
            array_push($na, $d['DIAG']);
        }
        ////////////////////////////////
        $m_list = MList::find()->all();
        return $this->render('hcode_region', [
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
     public function actionHcodepro($m1, $m2, $y) {
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
,CONCAT(sl.pdx,' ',sl.DIAGNAME) as DIAG
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_pdx_hcode sl
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
    and sl.prov1=$prov1
GROUP BY sl.PDX ORDER BY SUM(sl.N) DESC LIMIT 10";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);

        $rschart = \Yii::$app->db->createCommand("$sql")->queryAll();
        foreach ($rschart as $d) {
            array_push($n, intval($d['N']));
            array_push($na, $d['DIAG']);
        }

        ////////////////////////////////
        $m_list = MList::find()->all();
        //$p_list = Nhsozone::find()->where(['NHSO_ZONE' => 04])->groupBy('PROVINCE_ID')->all();
        $p_list = \Yii::$app->db->createCommand("SELECT PROVINCE_ID,PROVINCE_NAME from nhsozone_update  WHERE NHSO_ZONE=4")->queryAll();
        $p_name = \Yii::$app->db->createCommand("SELECT PROVINCE_NAME FROM nhsozone_update WHERE PROVINCE_ID=$prov1 GROUP BY PROVINCE_ID")->queryAll();
        return $this->render('hcode_pro', [
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
SUM(sl.N) as N,sl.REGIONCODE,sl.HCODE,sl.HCODEDESCR,sl.PROV1,sl.PURPROVDESCR
,sl.DATEDSC
,sl.DATEDSC_MONTH
,CONCAT(sl.pdx,' ',sl.DIAGNAME) as DIAG
,sum(sl.SUMNET) as SUMNET
,SUM(sl.ADJRW) as ADJRW
FROM rs_pdx_hmain sl
WHERE  sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' 
GROUP BY sl.PDX ORDER BY SUM(sl.N) DESC LIMIT 10";


        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $rschart = \Yii::$app->db->createCommand("$sql")->queryAll();
        foreach ($rschart as $d) {
            array_push($n, intval($d['N']));
            array_push($na, $d['DIAG']);
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
    
}

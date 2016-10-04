<?php

namespace frontend\controllers;

use yii;
use common\models\MList;
use common\models\Fundlist;
use common\models\NhsozoneUpdate;

class ReferController extends \yii\web\Controller
{
     public $enableCsrfValidation = false;
    public function actionIndex()
    {
              $sql = "SELECT FUNDCODE
,SUM(N) as N,SUM(sl.SUMNET),concat('ปีงบประมาณ',' ',sl.GYEAR) as GYEAR  FROM rs_ref_out as sl 
WHERE sl.FUNDCODE='IPAEC'
GROUP BY sl.GYEAR ";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
           $IPAEC = new \yii\data\ArrayDataProvider([
               'allModels' => $rs]);
           $sql2 = "SELECT FUNDCODE
,SUM(N) as N,SUM(sl.SUMNET),concat('ปีงบประมาณ',' ',sl.GYEAR) as GYEAR  FROM rs_ref_out as sl 
WHERE sl.FUNDCODE='IPINRGC'
GROUP BY sl.GYEAR ";
                  $rs2 = \Yii::$app->db->createCommand("$sql2")->queryAll();
           $IPINRGC = new \yii\data\ArrayDataProvider([
               'allModels' => $rs2]);
         $sql3="SELECT SUM(CASE WHEN FUNDCODE='IPAEC' THEN N ELSE 0 END) as IPAEC
,SUM(CASE WHEN FUNDCODE='IPINRGC' THEN N ELSE 0 END) as IPINRGC
,SUM(N) as N,concat('ปีงบประมาณ',' ',sl.GYEAR) as GYEAR  FROM rs_ref_out as sl GROUP BY sl.GYEAR";
            $rs3 = \Yii::$app->db->createCommand("$sql3")->queryAll();
           $dataProvider = new \yii\data\ArrayDataProvider([
               'allModels' => $rs3]);
           return $this->render('index',[
            'IPAEC'=>$IPAEC,'IPINRGC'=>$IPINRGC,'dataProvider'=>$dataProvider
            
        ]);
    }
public function actionAll()
    {
        return $this->render('all');
    }
     public function actionPro() {
        
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
        $sql = "SELECT sl.PURPROVDESCR as pro
,SUM(N) as N,SUM(sl.SUMNET) as NET FROM rs_ref_out as sl 
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.FUNDCODE ='IPINRGC' GROUP BY PROV1 ORDER BY SUM(N) DESC ";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $g = \Yii::$app->db->createCommand("SELECT sl.PURPROVDESCR as pro
,SUM(N) as N,SUM(sl.SUMNET) as NET FROM rs_ref_out as sl 
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.FUNDCODE ='IPINRGC' GROUP BY PROV1 ORDER BY SUM(N) DESC  limit 10")->queryAll();
        $n = [];
        $na = [];
        foreach ($g as $d) {
            array_push($n, (int)($d['N']));
            array_push($na,$d['pro']);
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
           'pagination' => [
        'pageSize' => 10,
    ],
        ]);
        $m_list = MList::find()->all();
        //$fundlist = Fundlist::find()->all();
        return $this->render('pro', [
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
    
    public function actionAepro() {
        
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
        $sql = "SELECT sl.PURPROVDESCR as pro
,SUM(N) as N,SUM(sl.SUMNET) as NET FROM rs_ref_out as sl 
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.FUNDCODE ='IPAEC' GROUP BY PROV1 ORDER BY SUM(N) DESC ";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $g = \Yii::$app->db->createCommand("SELECT sl.PURPROVDESCR as pro
,SUM(N) as N,SUM(sl.SUMNET) as NET FROM rs_ref_out as sl 
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
AND sl.FUNDCODE ='IPAEC' GROUP BY PROV1 ORDER BY SUM(N) DESC  limit 10")->queryAll();
        $n = [];
        $na = [];
        foreach ($g as $d) {
            array_push($n, (int)($d['N']));
            array_push($na,$d['pro']);
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
           'pagination' => [
        'pageSize' => 10,
    ],
        ]);
        $m_list = MList::find()->all();
        //$fundlist = Fundlist::find()->all();
        return $this->render('aepro', [
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
    public function actionHcode() {
        
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
        $sql = "SELECT sl.HCODEDESCR
,SUM(N) as N,SUM(sl.SUMNET) as NET FROM rs_ref_out as sl 
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND sl.FUNDCODE= 'IPINRGC'
GROUP BY HCODE ORDER BY SUM(N) DESC";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $g = \Yii::$app->db->createCommand("SELECT sl.HCODEDESCR
,SUM(N) as N,SUM(sl.SUMNET) as NET FROM rs_ref_out as sl 
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND sl.FUNDCODE= 'IPINRGC'
GROUP BY HCODE ORDER BY SUM(N) DESC limit 10")->queryAll();
        $n = [];
        $na = [];
        foreach ($g as $d) {          
            array_push($n, (int)($d['N']));
            array_push($na,$d['HCODEDESCR']);
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
           'pagination' => [
        'pageSize' => 10,
    ],
        ]);
        $m_list = MList::find()->all();
        //$fundlist = Fundlist::find()->all();
        return $this->render('hcode', [
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
    
     public function actionAehcode() {
        
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
        $sql = "SELECT sl.HCODEDESCR
,SUM(N) as N,SUM(sl.SUMNET) as NET FROM rs_ref_out as sl 
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND sl.FUNDCODE= 'IPAEC'
GROUP BY HCODE ORDER BY SUM(N) DESC";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $g = \Yii::$app->db->createCommand("SELECT sl.HCODEDESCR
,SUM(N) as N,SUM(sl.SUMNET) as NET FROM rs_ref_out as sl 
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND sl.FUNDCODE= 'IPAEC'
GROUP BY HCODE ORDER BY SUM(N) DESC limit 10")->queryAll();
        $n = [];
        $na = [];
        foreach ($g as $d) {          
            array_push($n, (int)($d['N']));
            array_push($na,$d['HCODEDESCR']);
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
           'pagination' => [
        'pageSize' => 10,
    ],
        ]);
        $m_list = MList::find()->all();
        //$fundlist = Fundlist::find()->all();
        return $this->render('aehcode', [
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
    public function actionDrg() {
        
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
        $sql = "SELECT COUNT(DISTINCT sl.SERVKEY) as N ,CONCAT(sl.drg,' ',c.drgname) as DRG 
from rs_ref_all sl 
LEFT OUTER JOIN ccmi51drg c ON c.DRG=sl.drg
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND sl.FUNDCODE= 'IPINRGC'
GROUP BY sl.DRG ORDER BY N DESC

";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $g = \Yii::$app->db->createCommand("SELECT COUNT(DISTINCT sl.SERVKEY) as N ,CONCAT(sl.drg,' ',c.drgname) as DRG 
from rs_ref_all sl 
LEFT OUTER JOIN ccmi51drg c ON c.DRG=sl.drg
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND sl.FUNDCODE= 'IPINRGC'
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
        //$fundlist = Fundlist::find()->all();
        return $this->render('drg', [
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
  
     public function actionPdx() {
        
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
        $sql = "SELECT COUNT(DISTINCT sl.SERVKEY) as N ,CONCAT(sl.pdx,' ',c.disease) as PDX 
from rs_ref_all sl JOIN cdisease c ON sl.PDX=c.diagcode
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND sl.FUNDCODE= 'IPINRGC'
GROUP BY sl.PDX ORDER BY N DESC
";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $g = \Yii::$app->db->createCommand("SELECT COUNT(DISTINCT sl.SERVKEY) as N ,CONCAT(sl.pdx,' ',c.disease) as PDX 
from rs_ref_all sl JOIN cdisease c ON sl.PDX=c.diagcode
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND sl.FUNDCODE= 'IPINRGC'
GROUP BY sl.PDX ORDER BY N DESC limit 10")->queryAll();
        $n = [];
        $na = [];
        foreach ($g as $d) {          
            array_push($n, (int)($d['N']));
            array_push($na,$d['PDX']);
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
           'pagination' => [
        'pageSize' => 10,
    ],
        ]);
        $m_list = MList::find()->all();
        //$fundlist = Fundlist::find()->all();
        return $this->render('pdx', [
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
    public function actionHmainpro() {
        
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
            //$fund = $request->post('fund');
           // $prov1 = $request->post('prov1');
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
        $sql = "SELECT COUNT(DISTINCT SERVKEY ) as N ,sl.PROVDESCR as pro,sl.PROV2
FROM rs_ref_all sl WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2'
GROUP BY PROV2 ";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $n = [];
        $na = [];
        foreach ($rs as $d) {
            array_push($n, intval($d['N']));
            array_push($na, $d['pro']);
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
//            'key' => 'PROVDESCR',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
        //$fundlist = Fundlist::find()->all();
        return $this->render('hmainpro', [
                    'n' => $n, 'na' => $na,
                    'y' => $y, 'm_list' => $m_list, 'm1' => $m1, 'm2' => $m2,
                    'dch1' => $dch1, 'dch2' => $dch2,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
     public function actionHmainhcode($m1, $m2, $y, $dch1, $dch2, $prov2) {
        
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
        $sql = "SELECT 
COUNT(DISTINCT SERVKEY ) as N ,sl.HMAINDESCR
FROM rs_ref_all sl 
WHERE sl.DATEDSC_MONTH BETWEEN '$dch1' AND '$dch2' AND PROV2=$prov2
GROUP BY HMAIN2 ";
        $rs = \Yii::$app->db->createCommand("$sql")->queryAll();
        $n = [];
        $na = [];
        foreach ($rs as $d) {
            array_push($n, intval($d['N']));
            array_push($na, $d['HMAINDESCR']);
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',//
            'allModels' => $rs,
            'pagination' => FALSE,
        ]);
        $m_list = MList::find()->all();
       $p_list = NhsozoneUpdate::find()->where(['NHSO_ZONE' => 04])->groupBy('PROVINCE_ID')->all();
        $p_name = \Yii::$app->db->createCommand("SELECT PROVINCE_NAME FROM nhsozone_update WHERE PROVINCE_ID=$prov2 GROUP BY PROVINCE_ID")->queryAll();
        return $this->render('hmainhcode', [
                    'n' => $n, 'na' => $na,
                    'y' => $y, 'm_list' => $m_list, 'm1' => $m1, 'm2' => $m2,
                    'dch1' => $dch1, 'dch2' => $dch2,
            'p_list'=>$p_list,'p_name'=>$p_name,'prov2'=>$prov2,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
   
}

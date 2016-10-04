<?php

namespace frontend\controllers;

use Yii;
use common\models\Webboard;
use common\models\WebboardSearch;
use common\models\Reply;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WebboardController implements the CRUD actions for Webboard model.
 */
class WebboardController extends Controller
{
   
      public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Webboard models.
     * @return mixed
     */
    public function actionIndex()
    {
    $rs=  Webboard::find()->all();
           $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rs,
                  'pagination' => [
        'pageSize' => 20,
    ],
        ]);

        return $this->render('index', [
           // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Webboard model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Webboard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Webboard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionReply($id)
    {
    
     
        $model = new Reply();
        $ids=$id;
         $head= Webboard::find()->where(['QuestionID'=>$ids])->all();
         $list =  Reply::find()->where(['QuestionID'=>$ids])->all();
         
        if ($model->load(Yii::$app->request->post())) {
            $model->QuestionID=$ids;
            $model->CreateDate=date('Y-m-d');
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('reply', [
                'model' => $model,'head'=>$head,'list'=>$list
            ]);
        }
    }

    /**
     * Updates an existing Webboard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->QuestionID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Webboard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Webboard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Webboard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Webboard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

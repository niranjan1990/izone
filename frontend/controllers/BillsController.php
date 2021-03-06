<?php

namespace frontend\controllers;

use frontend\models\Watches;
use Yii;
use frontend\models\Bills;
use frontend\models\BillsSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BillsController implements the CRUD actions for Bills model.
 */
class BillsController extends Controller
{
    public function behaviors()
    {
        return [
            /*'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['addBill'],
                        'allow' => true,
                        'roles' => ['*'],
                    ],
                ],
            ],*/
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Bills models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BillsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bills model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Bills model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bills();
        if (Yii::$app->request->isPost) {
            echo Json::encode(Yii::$app->request->post());
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Bills model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Bills model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bills model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bills the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bills::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBcontent($id){
        $watch =Watches::find()->joinWith('brands')->where(['watches.id' =>$id])->one();

        echo Json::encode(['modelno' => $watch->modelno, 'price' => $watch->price, 'brand' => $watch->brands->name]);

        /*foreach($watches as $watch){
            echo $watch->brands_id;
        }*/

       /* if($countPosts > 0 )
        {
            foreach($watches as $watch){
                echo "<input id='bills-description-0' value='".$watch->brands_id."' '>";
                echo "<option value='".$watch->id."'>" .$watch->modelno."</option>";
            }
        }else{
            echo "<option></option>";
        }*/
    }

    /*public function actionAddBill(){
        $this->render('addBill');
    }

    public function actionUpdateAjax()
    {
        $data = array();
        $data["myValue"] = "Content updated in AJAX";

        $this->renderPartial('addBill', $data, true, true);
    }*/

}

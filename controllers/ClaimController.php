<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\Claim;
use app\models\ClaimSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * ClaimController implements the CRUD actions for Claim model.
 */
class ClaimController extends Controller
{
    /**
     * {@inheritdoc}
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'status', 'index','update','view'],
                'rules' => [

                    [
                        'allow' => true,
                        'actions' => ['create', 'status', 'index','update','view'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ClaimSearch();
        //if (isset(Yii::$app->request->queryParams['ClaimSearch'])) {
        $array=[];
        if (isset(Yii::$app->request->queryParams['ClaimSearch'])) {
            $array = Yii::$app->request->queryParams;
        }
        else {
            if (Yii::$app->request->cookies->has('searchmodel'))
            {

                    $array=Yii::$app->request->cookies->getValue('searchmodel');

                    //print_r($array);
            } else {

                //print_r($array);


                if ($array['ClaimSearch']['dateorintext'] == '') {
                    $array['ClaimSearch']['dateorintext'] = '=' . date('d.m.Y');
                }

                $array['ClaimSearch']['cancel'] = '0';
            }
        }

        //print_r($searchModel);
       // print_r($array);
        if (Yii::$app->user->identity->status2 == '2') {
            $visible='0';
        }else{$visible='1';}

        if (Yii::$app->user->identity->status2 == '2') {

            $array['ClaimSearch']['orgname'] = Yii::$app->user->identity->orgname;

        }
        //
        //print_r($array);
        $dataProvider = $searchModel->search($array);
        $dataProvider->pagination->pageSize=15;
        if (isset(Yii::$app->request->queryParams['page'])) {
            $dataProvider->pagination->page = Yii::$app->request->queryParams['page'] - 1;
        }
        else
            {
                $dataProvider->pagination->page = $array['page'] - 1;
            }
            $items = ArrayHelper::map(\app\models\User::find()->all(),'id','username');

        $cookie = new \yii\web\Cookie([
            'name' => 'searchmodel',
            'value' => $array,

        ]);

        Yii::$app->response->cookies->add($cookie);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'visible' => $visible,
            'filters' => $items,
        ]);
    }
    public function actionIndexdel()
    {

        $searchModel = new ClaimSearch();
        $array=Yii::$app->request->queryParams;
        //print_r($array);
        $array['ClaimSearch']['cancel'] = '2';
        $model2 = New Claim();
        if ($model2->load(\Yii::$app->request->post()))
        {
            $datedel = strtotime($model2->datedel);
            Yii::$app->db->createCommand("
    update claim set cancel=2 where dateadd<".$datedel."; 
")->execute();
        }

        if (Yii::$app->user->identity->status2=='2')
        {
            $array['ClaimSearch']['orgid']=Yii::$app->user->identity->id;

        }
        //print_r($searchModel);
        if (Yii::$app->user->identity->status2 == '2') {
            $visible='0';
        }else{$visible='1';}
        $dataProvider = $searchModel->search($array);

        return $this->render('indexdel', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'visible' => $visible,
            'model2' => $model2,
        ]);
    }


    public function actionStatus($id)
    {

        $model = $this->findModel($id);
        if (isset($model->datein)&&!isset($model->dateout))
        {
            $model->dateout =time();
            $model->statusid =1;
            $model->statusloginid =Yii::$app->user->identity->id;


        }else{

            $model->datein =time();
            $model->statusid =3;
            $model->statusloginid =Yii::$app->user->identity->id;

        }
        if (isset($model->dateout)&&isset($model->datein))
        {
            $model->datein =time();
            $model->statusid =1;
            $model->statusloginid =Yii::$app->user->identity->id;
        }
        $model->save(false);
        return $this->redirect(['index']);
        //return Yii::$app->runAction('claim/index');
    }
    public function actionVosst($id)
    {

        $model = $this->findModel($id);
        $model->cancel = 0;
        $model->save(false);
        return Yii::$app->runAction('claim/indexdel');
    }


    /**
     * Displays a single Claim model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Claim model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Claim();


        if ($model->load(Yii::$app->request->post())) {
            $post=Yii::$app->request->post();

            $model->loginadd = Yii::$app->user->identity->id;
            $model->dateadd=time();

            $model->dateorin=strtotime($post['Claim']['dateorin']);
            $model->save(false);

            //$ClaimSearch=load(Yii::$app->request->get('ClaimSearch'));
            /*return $this->render('claim/index', [
                'ClaimSearch' => $ClaimSearch,
            ]);*/
            return $this->redirect(['index']);
           // return Yii::$app->runAction('claim/index');
        }else{

            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Updates an existing Claim model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->statusloginid = Yii::$app->user->identity->id;


        if ($model->load(Yii::$app->request->post())) {
            $post=Yii::$app->request->post();
            $model->dateorin=strtotime($post['Claim']['dateorin']);
            $model->save(false);
          //  return $this->redirect(['view', 'id' => $model->id]);

          return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionCancel($id)
    {
        $model = $this->findModel($id);

        if ((isset($model->datein))and(isset($model->dateout))) {

            Yii::$app->session->setFlash('warning', 'Невозможно отменить заявку. Автомашина уже была на территории.');
            return $this->redirect(['index']);
        }
        if ((isset($model->datein))) {

            Yii::$app->session->setFlash('warning', 'Невозможно отменить заявку. Автомашина въехала на территорию.');
            return $this->redirect(['index']);
        }
        if ($model->statusid==2){$model->statusid=0;}else{$model->statusid=2;}
        $model->statusloginid = Yii::$app->user->identity->id;
        $model->datechange=time();

        $model->save(false);
            //  return $this->redirect(['view', 'id' => $model->id]);
        return $this->redirect(['index']);


       /* return $this->render('update', [
            'model' => $model,
        ]);*/
    }

    /**
     * Deletes an existing Claim model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Claim model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Claim the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Claim::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

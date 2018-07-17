<?php

namespace modules\catalog\controllers\backend;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use modules\catalog\models\UploadForm;
use modules\catalog\models\CatalogProductImage;
use modules\catalog\models\search\CatalogProductImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use modules\catalog\Module;

/**
 * Class ProductImageController
 * @package modules\catalog\controllers\backend
 */
class ProductImageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CatalogProductImage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatalogProductImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CatalogProductImage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatalogProductImage([
            'scenario' => CatalogProductImage::SCENARIO_CREATE,
        ]);
        $uploadModel = new UploadForm();
        $error = [];

        if ($post = Yii::$app->request->post()) {
            $upload = new UploadForm([
                'dir' => $model->getDir($post['CatalogProductImage']['product_id']),
                'imageFiles' => UploadedFile::getInstances($uploadModel, 'imageFiles'),
                'size' => Module::$imageSize,
            ]);
            if ($fileNames = $upload->upload()) {
                foreach ($fileNames as $name) {
                    $model = new CatalogProductImage([
                        'scenario' => CatalogProductImage::SCENARIO_CREATE,
                    ]);
                    if ($model->load($post)) {
                        $model->image = $name;
                        if (!$model->save()) {
                            $error[] = "Error model save {$name}";
                        }
                    }
                }
                if (empty($error)) {
                    Yii::$app->session->setFlash('success', Module::t('module', 'Images successfully uploaded.'));
                } else {
                    $result = '';
                    foreach ($error as $item) {
                        $result .= $item . '<br>';
                    }
                    Yii::$app->session->setFlash('error', $result);
                }
            } else {
                Yii::$app->session->setFlash('success', Module::t('error', 'Error loading images!'));
            }
            return $this->redirect(Url::to(['index', 'CatalogProductImageSearch[product_id]' => $model->product_id]));
        }

        if (isset(Yii::$app->request->get()['id']) && !empty(Yii::$app->request->get()['id'])) {
            $model->product_id = Yii::$app->request->get()['id'];
        }

        return $this->render('create', [
            'model' => $model,
            'files' => $uploadModel,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPDATE;
        $uploadModel = new UploadForm([
            'dir' => $model->getDir(),
            'oldFile' => $model->image,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'files' => $uploadModel,
        ]);
    }

    /**
     * @param integer $id
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionSetStatus($id)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = $this->processChangeStatus($id);
            return [
                'result' => $result->statusLabelName,
            ];
        }
        $this->processChangeStatus($id);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id integer
     * @return CatalogProductImage
     * @throws NotFoundHttpException
     */
    protected function processChangeStatus($id)
    {
        $model = $this->findModel($id);
        $model->setStatus();
        $model->save(false);
        return $model;
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the CatalogProductImage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CatalogProductImage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatalogProductImage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Module::t('module', 'The requested page does not exist.'));
        }
    }
}

<?php

namespace admin\controllers;

use common\models\Apartments;
use common\models\ApartmentsSearch;
use common\models\Rooms;
use Yii;
use yii\helpers\ArrayHelper;
use Yii2\Extensions\DynamicForm\Models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ApartmentsController implements the CRUD actions for Apartments model.
 */
class ApartmentsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Apartments models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ApartmentsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Apartments model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Apartments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Apartments();
        $rooms = [new Rooms()];

        if ($model->load(Yii::$app->request->post())) {
            $rooms = Model::createMultiple(Rooms::class);
            Model::loadMultiple($rooms, Yii::$app->request->post(), 'Rooms');

            if (Model::validateMultiple($rooms) && $model->save()) {
                foreach ($rooms as $room) {
                    $room->apartment_id = $model->id;
                    $room->save();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'rooms' => (empty($rooms)) ? [new Rooms()] : $rooms, // передача комнат
        ]);
    }

    /**
     * Updates an existing Apartments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $rooms = $model->rooms;

        $pkey = 'id';

        if (empty($rooms)) {
            $rooms = [new Rooms()];
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $oldIDs = ArrayHelper::map($rooms, $pkey, $pkey);
                $rooms = Model::createMultiple(Rooms::class, $rooms, $pkey);
                Model::loadMultiple($rooms, $this->request->post(), 'Rooms');
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($rooms, $pkey, $pkey)));

                if (!empty($deletedIDs)) {
                    Rooms::deleteAll([$pkey => $deletedIDs]);
                }

                $valid = $model->validate();
                $valid = Model::validateMultiple($rooms) && $valid;

                if ($valid) {
                    if ($model->save()) {
                        foreach ($rooms as $room) {
                            $room->apartment_id = $model->id;
                            $room->save();
                        }
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'rooms' => (empty($rooms)) ? [new Rooms()] : $rooms,
        ]);
    }

    /**
     * Deletes an existing Apartments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Apartments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Apartments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apartments::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
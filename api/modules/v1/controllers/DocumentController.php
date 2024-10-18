<?php

namespace api\modules\v1\controllers;

use common\models\Documents;
use yii\helpers\ArrayHelper;

class DocumentController extends AppController
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authentificator' => [
                'except' => ['index']
            ]
        ]);
    }

    public function actionIndex(): array
    {
        $query = Documents::find();

        $id = $this->request->get('id');

        if ($id !== null) {
            $query->andFilterWhere(['id' => $id]);
        }

        $documents = $query->all();

        if ($id !== null) {
            if (empty($documents)) {
                return $this->returnError('Документ не найден.');
            }
            return $this->returnSuccess(['document' => $documents[0]]);
        }

        return $this->returnSuccess([
            'documents' => $documents,
        ]);
    }
}
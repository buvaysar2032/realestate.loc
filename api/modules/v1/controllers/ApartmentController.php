<?php

namespace api\modules\v1\controllers;

use common\models\Apartments;
use yii\helpers\ArrayHelper;

class ApartmentController extends AppController
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
        $query = Apartments::find();

        $id = $this->request->get('id');

        if ($id !== null) {
            $query->andFilterWhere(['id' => $id]);
        } else {
            $query->andFilterWhere(['>', 'available', 0]);
        }

        $apartments = $query->all();

        if ($id !== null) {
            if (empty($apartments)) {
                return $this->returnError('Квартира не найдена.');
            }
            return $this->returnSuccess(['apartment' => $apartments[0]]);
        }

        return $this->returnSuccess([
            'apartments' => $apartments,
        ]);
    }
}
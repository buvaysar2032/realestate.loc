<?php

namespace api\modules\v1\controllers;

use common\models\Texts;
use yii\helpers\ArrayHelper;

class TextController extends AppController
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
        $query = Texts::find();

        $id = $this->request->get('id');

        if ($id !== null) {
            $query->andFilterWhere(['id' => $id]);
        }

        $texts = $query->all();

        if ($id !== null) {
            if (empty($texts)) {
                return $this->returnError('Текст не найден.');
            }
            return $this->returnSuccess(['text' => $texts[0]]);
        }

        return $this->returnSuccess([
            'texts' => $texts,
        ]);
    }
}
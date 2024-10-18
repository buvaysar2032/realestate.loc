<?php

namespace api\modules\v1\controllers;

use common\models\GalleryImages;
use yii\helpers\ArrayHelper;

class GalleryController extends AppController
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
        $query = GalleryImages::find();
        $galleryId = $this->request->get('gallery_id');

        if ($galleryId !== null) {
            $query->andFilterWhere(['gallery_id' => $galleryId]);
            $images = $query->all();

            if (empty($images)) {
                return $this->returnError('Изображения для данной галереи не найдены.');
            }

            return $this->returnSuccess(['images' => $images]);
        }

        $images = $query->all();
        $groupedImages = [];

        foreach ($images as $image) {
            $groupedImages[$image->gallery_id][] = $image;
        }

        return $this->returnSuccess(['grouped_images' => $groupedImages]);
    }
}
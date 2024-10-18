<?php

use common\models\GalleryImages;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\GalleryImagesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Gallery Images');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['galleries/index']];
$this->params['breadcrumbs'][] = ['label' => $searchModel->gallery->title, 'url' => ['galleries/view', 'id' => $searchModel->gallery_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-images-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Gallery Images'), ['create', 'gallery_id' => $searchModel->gallery_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'gallery_id',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->image ? Html::img('/' . $model->image, ['alt' => 'Изображение поста', 'style' => 'width: auto; height: auto']) : Yii::t('app', 'Нет изображения');
                },
            ],
            'title',
            'text:ntext',

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, GalleryImages $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>

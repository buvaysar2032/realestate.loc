<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\GalleryImages $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['galleries/index']];
$this->params['breadcrumbs'][] = ['label' => $model->gallery->title, 'url' => ['galleries/view', 'id' => $model->gallery_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gallery Images'), 'url' => ['index', 'gallery_id' => $model->gallery_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gallery-images-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        ],
    ]) ?>

</div>

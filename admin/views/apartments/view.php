<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Apartments $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Apartments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="apartments-view">

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
            'title',
            'subtitle',
            'description:ntext',
            'price',
            'floor',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->image ? Html::img('/' . $model->image, ['alt' => 'Изображение поста', 'style' => 'width: auto; height: auto']) : Yii::t('app', 'Нет изображения');
                },
            ],
            'address',
            'additional_title',
            [
                'label' => Yii::t('app', 'Rooms'),
                'format' => 'raw',
                'value' => function ($model) {
                    $roomsList = '';
                    foreach ($model->rooms as $room) {
                        $roomsList .= Html::tag('li', Html::encode($room->name));
                    }
                    return Html::tag('ul', $roomsList);
                },
            ],
            [
                'attribute' => 'svg_image',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->svg_image ? Html::img('/' . $model->svg_image, ['alt' => 'Изображение поста', 'style' => 'width: auto; height: auto']) : Yii::t('app', 'Нет изображения');
                },
            ],
            //'available',
            [
                'attribute' => 'available',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->available ? Yii::t('app', 'Да') : Yii::t('app', 'Нет');
                },
            ],
        ],
    ]) ?>

</div>
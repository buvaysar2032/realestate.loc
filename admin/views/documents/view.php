<?php

use common\models\Documents;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Documents $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="documents-view">

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
            'key',
            [
                'attribute' => 'file',
                'format' => 'raw',
                'value' => function (Documents $model) {
                    if ($model->file) {
                        $fileName = basename($model->file);
                        return Html::a($fileName, '/' . $model->file, [
                            'alt' => 'Скачать файл',
                            'style' => 'width: auto; height: auto',
                            'download' => true
                        ]);
                    }
                    return Yii::t('app', 'Не задано');
                },
            ],
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\GalleryImages $model */

$this->title = Yii::t('app', 'Create Gallery Images');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['galleries/index']];
$this->params['breadcrumbs'][] = ['label' => $model->gallery->title, 'url' => ['galleries/view', 'id' => $model->gallery_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gallery Images'), 'url' => ['index', 'gallery_id' => $model->gallery_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-images-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

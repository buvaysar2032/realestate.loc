<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Apartments $model */
/** @var common\models\Rooms[] $rooms */

$this->title = Yii::t('app', 'Update Apartments: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Apartments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="apartments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'rooms' => $rooms,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Apartments $model */
/** @var common\models\Rooms[] $rooms */

$this->title = Yii::t('app', 'Create Apartments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Apartments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apartments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'rooms' => $rooms
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Galleries $model */

$this->title = Yii::t('app', 'Create Galleries');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="galleries-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

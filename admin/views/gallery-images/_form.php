<?php

use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\GalleryImages $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="gallery-images-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gallery_id')->hiddenInput()->label(false) ?>

    <br>
    <?= $form->field($model, 'imageFile')->fileInput(['maxlength' => true]) ?>
    <br>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <br>
    <?php
    echo $form->field($model, 'text')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 100,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
            'clips' => [
                ['Lorem ipsum...', 'Lorem...'],
                ['red', '<span class="label-red">red</span>'],
                ['green', '<span class="label-green">green</span>'],
                ['blue', '<span class="label-blue">blue</span>'],
            ],
        ],
    ]);
    ?>

    <br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

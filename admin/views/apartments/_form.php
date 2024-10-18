<?php

use vova07\imperavi\Widget;
use Yii2\Extensions\DynamicForm\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Apartments $model */
/** @var common\models\Rooms $rooms */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="apartments-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <br>

    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>
    <br>

    <?php
    echo $form->field($model, 'description')->widget(Widget::className(), [
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

    <?= $form->field($model, 'price')->textInput() ?>
    <br>

    <?= $form->field($model, 'floor')->textInput() ?>
    <br>

    <?= $form->field($model, 'imageFile')->fileInput(['maxlength' => true]) ?>
    <br>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    br

    <?= $form->field($model, 'additional_title')->textInput(['maxlength' => true]) ?>
    <br>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',
                'widgetBody' => '.container-items',
                'widgetItem' => '.item',
                'limit' => 99,
                'min' => 1,
                'insertButton' => '.add-item',
                'deleteButton' => '.remove-item',
                'model' => $rooms[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'name',
                    'area',
                    'uid',
                ],
            ]); ?>

            <div class="container-items">
                <?php foreach ($rooms as $i => $room): ?>
                    <div class="item panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Комната</h3>
                            <div class="pull-right">
                                <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i>Добавить</button>
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i>Удалять</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            if (! $room->isNewRecord) {
                                echo Html::activeHiddenInput($room, "[{$i}]id");
                            }
                            ?>

                            <?= $form->field($room, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                            <?= $form->field($room, "[{$i}]area")->textInput(['maxlength' => true]) ?>
                            <?= $form->field($room, "[{$i}]uid")->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <br>
    <?= $form->field($model, 'imageFile2')->fileInput(['maxlength' => true]) ?>

    <br>
    <?= $form->field($model, 'available')->checkbox() ?>

    <br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
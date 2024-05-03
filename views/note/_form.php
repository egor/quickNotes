<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Note $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="note-form">

    <?php
    $form = ActiveForm::begin();

    //echo $form->field($model, 'user_id')->textInput();
    //echo $form->field($model, 'created_at')->textInput();
    //echo $form->field($model, 'updated_at')->textInput();

    echo $form->field($model, 'user_date')->widget(DateControl::classname(), [
        'value' => $model->user_date,
        'type'=>DateControl::FORMAT_DATETIME,
        'displayTimezone' => 'Europe/Kiev',
        'displayFormat' => 'php:D, d.m.Y H:i:s',
        'saveFormat' => 'php:U',
    ]);
    echo $form->field($model, 'header')->textInput(['maxlength' => true, 'autofocus' => true]);
    //echo $form->field($model, 'userTag')->textInput(['maxlength' => true]);
    $url = \yii\helpers\Url::to(['tag-list']);
    echo $form->field($model, 'userTag')->widget(Select2::classname(), [
        //'data' => $tags,
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
            'tags' => true,
            'tokenSeparators' => [', ', ' '],

            'minimumInputLength' => 1,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(tag) { return tag.text; }'),
            'templateSelection' => new JsExpression('function (tag) { return tag.text; }'),
        ],
    ]);

    echo $form->field($model, 'description')->textarea(['rows' => 6]);
    ?>

    <div class="form-group d-grid gap-2 d-md-flex justify-content-md-end">
        <?php
        echo Html::a(Yii::t('app', 'Cancel'), ['/note'], ['class' => 'btn btn-default']) . ' ';
        echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']);
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

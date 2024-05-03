<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var app\models\NoteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="note-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'autocomplete' => 'off'
        ],
    ]); ?>

    <?php
    //echo $form->field($model, 'id');

    //echo $form->field($model, 'user_id');

    //echo $form->field($model, 'created_at');

    //echo $form->field($model, 'updated_at');
    echo $form->field($model, 'dateRange', [
        'addon' => [
            'prepend' => [
                'content' => '<i class="fas fa-calendar-alt"></i>'
            ]
        ],
        'options' => ['class' => 'drp-container mb-2']
    ])->widget(DateRangePicker::classname(), [
        'useWithAddon' => true,
        'pluginOptions'=>[
            //'locale'=>['format'=>'d.m.Y']
            'locale'=>['format' => 'DD-MM-YYYY'],
        ],
        'pjaxContainerId'=>'note-data',
    ]);

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
    //echo $form->field($model, 'user_date');

    echo $form->field($model, 'header');

    //echo $form->field($model, 'description');
    ?>

    <div class="form-group">
        <?php
        echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) . ' ';
        echo Html::a(Yii::t('app', 'Reset'), ['/note'], ['class' => 'btn btn-outline-secondary']);
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

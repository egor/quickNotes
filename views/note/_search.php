<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\form\ActiveForm;


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

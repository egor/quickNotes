<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\web\View;

/** @var yii\web\View $this */
/** @var app\models\NoteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>


<div class="collapse" id="collapseSearchNote">
    <div class="note-search card card-body">

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
            'options' => ['placeholder' => 'Select a tag ...'],
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

        <div class="form-group d-grid gap-2 d-md-flex justify-content-md-end">
            <?php
            echo Html::a(Yii::t('app', 'Reset'), ['/note'], ['class' => 'btn btn-outline-secondary']) . ' ';
            echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']);
            ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <br />
</div>
<div class="clearfix"></div>
<?php
$this->registerJs('
if (localStorage.getItem("collapseSearchNote") == "show") {
    $("#collapseSearchNote").addClass("show");
    $("#collapseSearchNoteText").html("Hide search");
}
//alert($("#notesearch-usertag").val()); 
//alert($(".select2-selection__choice").html());
if (filterHasData() == true && localStorage.getItem("collapseSearchNote") != "show") {
    $("#top-reset-search").removeClass("d-none");
    $("#collapseSearchNoteBadge").removeClass("d-none");
}

collapseSearchNote = document.getElementById("collapseSearchNote");
collapseSearchNote.addEventListener("hidden.bs.collapse", event => {
    $("#collapseSearchNoteText").html("Show search");
    localStorage.setItem("collapseSearchNote", "hide");
    //$("#top-reset-search").addClass("d-none");
    if (filterHasData() == true) {
        $("#top-reset-search").removeClass("d-none");
        $("#collapseSearchNoteBadge").removeClass("d-none");
    }
});
collapseSearchNote.addEventListener("shown.bs.collapse", event => {
    $("#collapseSearchNoteText").html("Hide search");
    localStorage.setItem("collapseSearchNote", "show");
    $("#top-reset-search").addClass("d-none");
    $("#collapseSearchNoteBadge").addClass("d-none");
});
function filterHasData() {
    if ($("#notesearch-usertag").val() != undefined && $("#notesearch-usertag").val() != "") {
        return true;
    }
    if ($("#notesearch-header").val() != undefined && $("#notesearch-header").val() != "") {
        return true;
    }
    if ($("#notesearch-daterange").val() != undefined && $("#notesearch-daterange").val() != "") {
        return true;
    }
    return false;
}
$("#notesearch-daterange").on("focus",function(){
    $(this).trigger("blur");
});
', View::POS_END, 'search-note-js');
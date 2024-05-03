<?php

use app\models\Note;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\web\View;

/** @var yii\web\View $this */
/** @var app\models\NoteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Notes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    echo \app\widgets\navigate\NoteDisplay::widget();
    ?>
    <div class="d-flex justify-content-between">
        <div>
            <a class="btn btn-light position-relative" data-bs-toggle="collapse" href="#collapseSearchNote" role="button" aria-expanded="false" aria-controls="collapseSearchNote">
                <i class="fas fa-search"></i> <span id="collapseSearchNoteText">Show search</span>
                <span id="collapseSearchNoteBadge" class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle d-none">
                    <span class="visually-hidden">Has search data</span>
                </span>
            </a>
            &nbsp;
            <a href="/note/index" class="btn btn-light d-none" role="button" aria-expanded="false" id="top-reset-search">
                <i class="fas fa-times"></i> Reset search
            </a>
        </div>
        <div>
            <?php echo Html::a('<i class="fas fa-plus"></i> ' . Yii::t('app', 'Create Note'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <br />

    <?php
    Pjax::begin(['id' => 'note-data']);
    echo $this->render('_search', ['model' => $searchModel]);
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_msgItem',
        'pager' => ['class' => \yii\bootstrap5\LinkPager::class],
    ]);
    Pjax::end();
    ?>

    <!-- Modal -->
    <div class="modal fade" id="editNoteFormModal" tabindex="-1" aria-labelledby="editNoteFormModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editNoteFormModalBody">
                    ...
                </div>

            </div>
        </div>
    </div>

</div>
<?php
$this->registerJs('
$(".showDetail").on("click", function(){
    console.log(this.getAttribute("data-id"));
    id = this.getAttribute("data-id");
    $.ajax({
        url: "/note/view?id=" + id,         /* Куда отправить запрос */
        method: "get",             /* Метод запроса (post или get) */
        dataType: "html",          /* Тип данных в ответе (xml, json, script, html). */
        
        success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
             $("#editNoteFormModalBody").html(data);
        }
    });
});
', View::POS_READY, 'msg-note-js');
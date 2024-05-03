<?php

use app\models\Note;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;


/** @var yii\web\View $this */
/** @var app\models\NoteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Notes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex justify-content-between">
        <div>
            <a class="btn btn-light" data-bs-toggle="collapse" href="#collapseSearchNote" role="button" aria-expanded="false" aria-controls="collapseSearchNote">
                <i class="fas fa-search"></i> <span id="collapseSearchNoteText">Show search</span>
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

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'user_id',
            //'created_at',
            //'updated_at',
            [
                'attribute' => 'user_date',
                'format' => ['datetime', 'php:D, d.m.Y H:i:s'],
                'filter' => false,
            ],
            [
                'attribute' => 'header',
                'format' => 'html',
                'value' => function ($model) {
                    $tags = '';
                    if (!empty($model['tag'])) {
                        foreach ($model['tag'] as $tag) {
                            $tags .= ' <a href="/note/by-tag?tag=' . $tag['name'] . '" class="link-underline-opacity-0"><span class="badge text-bg-secondary">' . $tag['name'] . '</span></a>';
                        }
                    }
                    return $model['header'] . (!empty($tags) ? '<br />' . $tags : '');
                }
            ],
            //'description:ntext',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Note $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
        'pager' => ['class' => \yii\bootstrap5\LinkPager::class],
    ]);

    Pjax::end();
    ?>

</div>
<?php

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

    <p>
        <?= Html::a(Yii::t('app', 'Create Note'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
            'header',
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

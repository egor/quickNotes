<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Note $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="note-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'user_id',
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:D, d.m.Y H:i:s']
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['datetime', 'php:D, d.m.Y H:i:s']
            ],
            [
                'attribute' => 'user_date',
                'format' => ['datetime', 'php:D, d.m.Y H:i:s']
            ],
            'header',
            [
                'attribute' => 'userTag',
                'value' => function ($model) {
                    if (!empty($model->userTag)) {
                        return implode(', ', $model->userTag);
                    }
                    return '';
                }
            ],
            'description:ntext',
        ],
    ]) ?>

</div>

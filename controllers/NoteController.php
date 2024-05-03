<?php

namespace app\controllers;

use app\models\Note;
use app\models\NoteSearch;
use app\models\NoteTag;
use app\models\Tag;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\Query;

/**
 * NoteController implements the CRUD actions for Note model.
 */
class NoteController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Note models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new NoteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        $dataProvider->sort->defaultOrder = ['user_date' => SORT_DESC];

        if (!empty($_SESSION['noteDisplay']) && $_SESSION['noteDisplay'] == 'msg') {
            return $this->render('msg', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Note model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        //@todo to func
        $userTag = NoteTag::find()
            ->where('note_id = :note_id', [':note_id' => $id])
            ->all();

        if (!empty($userTag)) {
            foreach ($userTag as $tag) {
                $model->oldUserTag[$tag['tag_id']] = $tag['tag']['name'];// .= $tag['id'] . ', ';
            }
            $model->userTag = $model->oldUserTag;
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('view', [
                'model' => $model,
            ]);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Note model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Note();
        $model->user_id = Yii::$app->user->id;
        $model->user_date = time();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                //return $this->redirect(['view', 'id' => $model->id]);
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Note model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userTag = NoteTag::find()
            ->where('note_id = :note_id', [':note_id' => $id])
            ->all();

        if (!empty($userTag)) {
            foreach ($userTag as $tag) {
                $model->oldUserTag[$tag['tag_id']] = $tag['tag']['name'];// .= $tag['id'] . ', ';
            }
            $model->userTag = $model->oldUserTag;
        }
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $tags = ArrayHelper::map(Tag::find()->select(['id', 'name'])->all(), 'name', 'name');
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Note model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Note model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Note the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Note::findOne(['id' => $id, 'user_id' => Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionTagList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            //$query->select('id, name AS text')
            $query->select('name AS id, name AS text')
                ->from('tag')
                ->where(['like', 'name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $name = Tag::find($id)->name;
            $out['results'] = ['id' => $name, 'text' => $name];
            //$out['results'] = ['id' => $id, 'text' => Tag::find($id)->name];
        }
        return $out;
    }

    public function actionDisplay($as)
    {
        switch ($as) {
            case 'msg':
                $_SESSION['noteDisplay'] = 'msg';
                break;
            default:
                $_SESSION['noteDisplay'] = 'table';
        }
        return $this->redirect(['index']);
    }
}

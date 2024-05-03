<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "note".
 *
 * @property int $id
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $user_date
 * @property string $header
 * @property string $description
 */
class Note extends \yii\db\ActiveRecord
{
    public $userTag;
    public $oldUserTag = [];
    public $dateRange;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'note';
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['user_id', 'created_at', 'updated_at', 'user_date', 'header', 'description'], 'required'],
            [['user_id', 'header'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'user_date'], 'integer'],
            //[['description', 'userTag'], 'string'],
            [['description'], 'string'],
            [['userTag'], 'safe'],
            [['header'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_date' => Yii::t('app', 'Date'),
            'header' => Yii::t('app', 'Header'),
            'description' => Yii::t('app', 'Description'),
            'userTag' => Yii::t('app', 'Tags'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return NoteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NoteQuery(get_called_class());
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $newUserTag = [];
        if (!empty($this->userTag)) {
            $tagArr = array_values($this->userTag);

            foreach ($tagArr as $tag) {
                $tag = trim($tag);
                if (!empty($tag) && empty(array_search($tag, $newUserTag))) {

                    $tagId = Tag::find()->select('id')->where('name = :name', [':name' => $tag])->scalar();
                    if (!empty($tagId)) {

                    } else {

                        $newTag = new Tag();
                        $newTag->name = $tag;
                        $newTag->user_id = Yii::$app->user->id;
                        $newTag->save();
                        $tagId = $newTag->id;

                    }
                    $newUserTag[$tagId] = $tag;
                    if (isset($this->oldUserTag[$tagId])) {
                        unset($this->oldUserTag[$tagId]);
                    } else {
                        $noteTag = new NoteTag();
                        $noteTag->note_id = $this->id;
                        $noteTag->tag_id = $tagId;
                        $noteTag->position = 0;
                        $noteTag->save();
                    }
                }
            }
        }
        if (!empty($this->oldUserTag)) {
            foreach ($this->oldUserTag as $oldUserTagKey => $oldUserTagValue) {
                NoteTag::deleteAll(['note_id' => $this->id, 'tag_id' => $oldUserTagKey]);
            }
        }

    }

    public function getTag()
    {
        /*
        return $this
            ->hasMany(NoteTag::className(), ['id' => 'id'])
            ->viaTable('tag', ['note_id' => 'id']);
        */
        return $this
            ->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('note_tag', ['note_id' => 'id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "note_tag".
 *
 * @property int $id
 * @property int $note_id
 * @property int $tag_id
 * @property int $position
 */
class NoteTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'note_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['note_id', 'tag_id', 'position'], 'required'],
            [['note_id', 'tag_id', 'position'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'note_id' => Yii::t('app', 'Note ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return NoteTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NoteTagQuery(get_called_class());
    }

    public function getTag()
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }
}

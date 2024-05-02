<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[NoteTag]].
 *
 * @see NoteTag
 */
class NoteTagQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return NoteTag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return NoteTag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

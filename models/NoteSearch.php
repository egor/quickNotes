<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Note;

/**
 * NoteSearch represents the model behind the search form of `app\models\Note`.
 */
class NoteSearch extends Note
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_at', 'updated_at', 'user_date'], 'integer'],
            [['header', 'description', 'dateRange'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Note::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->dateRange)) {

            $dateTimeRange = explode(' - ', $this->dateRange);
            if (!empty($dateTimeRange[0]) && !empty($dateTimeRange[1])) {

                $dateTimeRange[0] = strtotime($dateTimeRange[0]);
                $dateTimeRange[1] = strtotime($dateTimeRange[1]) + 60 * 60 * 24;

                if ($dateTimeRange[0] > 0 && $dateTimeRange[1] > 0 && $dateTimeRange[0] < $dateTimeRange[1]) {

                    $query->andFilterWhere(['>=', 'user_date', $dateTimeRange[0]])
                        ->andFilterWhere(['<', 'user_date', $dateTimeRange[1]]);
                }
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_date' => $this->user_date,
        ]);

        $query->andFilterWhere(['like', 'header', $this->header])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}

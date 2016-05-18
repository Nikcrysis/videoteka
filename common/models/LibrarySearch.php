<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Library;

/**
 * LibrarySearch represents the model behind the search form about `app\models\Library`.
 */
class LibrarySearch extends Library
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'year', 'count_all', 'count_taken', 'prce_for_sale', 'prce_for_take', 'q_taken', 'q_bought', 'q_viewed'], 'integer'],
            [['name', 'genre'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Library::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'year' => $this->year,
            'count_all' => $this->count_all,
            'count_taken' => $this->count_taken,
            'prce_for_sale' => $this->prce_for_sale,
            'prce_for_take' => $this->prce_for_take,
            'q_taken' => $this->q_taken,
            'q_bought' => $this->q_bought,
            'q_viewed' => $this->q_viewed,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'genre', $this->genre]);

        return $dataProvider;
    }
}

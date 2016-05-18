<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Actions;

/**
 * ActionsSearch represents the model behind the search form about `common\models\Actions`.
 */
class ActionsSearch extends Actions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'film_id', 'user_id'], 'integer'],
            [['type', 'date'], 'safe'],
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
        $query = Actions::find();

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

        if ($this->date != '') {
            $date_from = strtotime($this->date);
            $date_to = $date_from + 24*60*60;
            $query->andFilterWhere(['>=', 'date', $date_from]);
            $query->andFilterWhere(['<=', 'date', $date_to]);
        } else {
            $query->andFilterWhere(['date' => $this->date,]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'film_id' => $this->film_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);


        return $dataProvider;
    }

}

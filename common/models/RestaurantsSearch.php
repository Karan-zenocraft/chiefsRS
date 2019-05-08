<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Restaurants;

/**
 * RestaurantsSearch represents the model behind the search form of `common\models\Restaurants`.
 */
class RestaurantsSearch extends Restaurants
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pincode', 'contact_no', 'status'], 'integer'],
            [['name', 'description', 'address', 'city', 'state', 'country', 'website', 'email', 'max_stay_time_after_reservation', 'created_at', 'updated_at'], 'safe'],
            [['lattitude', 'longitude'], 'number'],
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
        $query = Restaurants::find();

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
            'pincode' => $this->pincode,
            'lattitude' => $this->lattitude,
            'longitude' => $this->longitude,
            'contact_no' => $this->contact_no,
            'max_stay_time_after_reservation' => $this->max_stay_time_after_reservation,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}

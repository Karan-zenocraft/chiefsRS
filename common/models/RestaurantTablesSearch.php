<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RestaurantTables;

/**
 * RestaurantTablesSearch represents the model behind the search form of `common\models\RestaurantTables`.
 */
class RestaurantTablesSearch extends RestaurantTables
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'restaurant_id', 'layout_id', 'table_no', 'min_capacity', 'max_capacity', 'created_by', 'updated_by', 'status'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'safe'],
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
        $query = RestaurantTables::find();

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
            'restaurant_id' => $this->restaurant_id,
            'layout_id' => $this->layout_id,
            'table_no' => $this->table_no,
            'min_capacity' => $this->min_capacity,
            'max_capacity' => $this->max_capacity,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

       public function backendsearch($params)
        {
        $query = RestaurantTables::find()->where(['restaurant_id'=>$_GET['rid'],'layout_id'=>$_GET['lid']]);

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
            'restaurant_id' => $this->restaurant_id,
            'layout_id' => $this->layout_id,
            'table_no' => $this->table_no,
            'min_capacity' => $this->min_capacity,
            'max_capacity' => $this->max_capacity,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}

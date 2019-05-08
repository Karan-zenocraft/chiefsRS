<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RestaurantsGallery;

/**
 * RestaurantsGallerySearch represents the model behind the search form of `common\models\RestaurantsGallery`.
 */
class RestaurantsGallerySearch extends RestaurantsGallery
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'restaurant_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['image_title', 'image_description', 'image_name', 'created_at', 'updated_at'], 'safe'],
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
        $query = RestaurantsGallery::find();

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
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'image_title', $this->image_title])
            ->andFilterWhere(['like', 'image_description', $this->image_description])
            ->andFilterWhere(['like', 'image_name', $this->image_name]);

        return $dataProvider;
    }

     public function backendSearch( $params ) {
        $query = RestaurantsGallery::find();

        $dataProvider = new ActiveDataProvider( [
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]],

            ] );

        if ( !( $this->load( $params ) && $this->validate() ) ) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'restaurants.id' => $this->id,
            'restaurants.restaurant_id' => $this->restaurant_id,
            'restaurants.status' => $this->status,
            'restaurants.created_by' => $this->created_by,
            'restaurants.updated_by' => $this->updated_by,
            'restaurants.created_at' => $this->created_at,
            'restaurants.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere( ['like', 'name', $this->name] )
        ->andFilterWhere( ['like', 'description', $this->description] );

        return $dataProvider;
    }
}

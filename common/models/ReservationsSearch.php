<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Reservations;

/**
 * ReservationsSearch represents the model behind the search form of `common\models\Reservations`.
 */
class ReservationsSearch extends Reservations
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'restaurant_id', 'layout_id', 'table_id', 'no_of_guests', 'status','total_stay_time'], 'integer'],
            [['date', 'booking_start_time', 'booking_end_time', 'total_stay_time', 'pickup_drop', 'pickup_location', 'pickup_time', 'drop_location', 'drop_time', 'special_comment', 'created_at', 'updated_at','first_name','last_name','email','tag_id'], 'safe'],
            [['pickup_lat', 'pickup_long', 'drop_lat', 'drop_long','contact_no'], 'number'],
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
    public function backendSearch($params)
    {
        $query = Reservations::find()->where(['user_id'=>$params['user_id']]);

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
            'user_id' => $this->user_id,
            'restaurant_id' => $this->restaurant_id,
            'layout_id' => $this->layout_id,
            'table_id' => $this->table_id,
            'date' => $this->date,
            'contact_no' => $this->contact_no,
            'booking_start_time' => $this->booking_start_time,
            'booking_end_time' => $this->booking_end_time,
            'total_stay_time' => $this->total_stay_time,
            'no_of_guests' => $this->no_of_guests,
            'pickup_lat' => $this->pickup_lat,
            'pickup_long' => $this->pickup_long,
            'pickup_time' => $this->pickup_time,
            'drop_lat' => $this->drop_lat,
            'drop_long' => $this->drop_long,
            'drop_time' => $this->drop_time,
            'tag_id' => $this->tag_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'pickup_drop', $this->pickup_drop])
            ->andFilterWhere(['like', 'pickup_location', $this->pickup_location])
            ->andFilterWhere(['like', 'drop_location', $this->drop_location])
            ->andFilterWhere(['like', 'special_comment', $this->special_comment]);

        return $dataProvider;
    }

    public function forntendSearch($params)
    {
        $query = Reservations::find()->where("status !=".Yii::$app->params['reservation_status_value']['deleted']." AND user_id = ".Yii::$app->user->id);

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
            'user_id' => $this->user_id,
            'restaurant_id' => $this->restaurant_id,
            'layout_id' => $this->layout_id,
            'table_id' => $this->table_id,
            'date' => $this->date,
          //  'booking_start_time' => $this->booking_start_time,
            'booking_end_time' => $this->booking_end_time,
            'total_stay_time' => $this->total_stay_time,
            'no_of_guests' => $this->no_of_guests,
            'pickup_lat' => $this->pickup_lat,
            'pickup_long' => $this->pickup_long,
            'pickup_time' => $this->pickup_time,
            'drop_lat' => $this->drop_lat,
            'drop_long' => $this->drop_long,
            'drop_time' => $this->drop_time,
            'tag_id' => $this->tag_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'pickup_drop', $this->pickup_drop])
            ->andFilterWhere(['like', 'pickup_location', $this->pickup_location])
            ->andFilterWhere(['like', 'drop_location', $this->drop_location])
            ->andFilterWhere(['like', 'special_comment', $this->special_comment]);
       if(!empty($params['ReservationsSearch']) && !empty($params['ReservationsSearch']['booking_start_time'])){
            $booking_start_time = date("H:i:s", strtotime($params['ReservationsSearch']['booking_start_time']));
            $dataProvider->query->andFilterWhere(['booking_start_time'=>$booking_start_time]);
        }
        return $dataProvider;
    }
}

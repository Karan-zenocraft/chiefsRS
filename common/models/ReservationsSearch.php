<?php

namespace common\models;

use common\models\Reservations;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

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
            [['id', 'user_id', 'restaurant_id', 'floor_id', 'table_id', 'no_of_guests', 'status', 'total_stay_time'], 'integer'],
            [['date', 'booking_start_time', 'booking_end_time', 'total_stay_time', 'pickup_drop', 'pickup_location', 'pickup_time', 'drop_location', 'drop_time', 'special_comment', 'created_at', 'updated_at', 'tag_id'], 'safe'],
            [['pickup_lat', 'pickup_long', 'drop_lat', 'drop_long'], 'number'],
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
        $query = Reservations::find()->where("user_id = '" . $params['user_id'] . "' AND status !=" . Yii::$app->params['reservation_status_value']['deleted']);

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
            'floor_id' => $this->floor_id,
            'table_id' => $this->table_id,
            'date' => $this->date,
            // 'contact_no' => $this->contact_no,
            // 'booking_start_time' => $this->booking_start_time,
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

        /*    andFilterWhere(['like', 'first_name', $this->first_name])
        ->andFilterWhere(['like', 'last_name', $this->last_name])
        ->andFilterWhere(['like', 'email', $this->email])*/
        $query->andFilterWhere(['like', 'pickup_drop', $this->pickup_drop])
            ->andFilterWhere(['like', 'pickup_location', $this->pickup_location])
            ->andFilterWhere(['like', 'drop_location', $this->drop_location])
            ->andFilterWhere(['like', 'special_comment', $this->special_comment]);

        if (!empty($params['ReservationsSearch']) && !empty($params['ReservationsSearch']['booking_start_time'])) {
            $booking_start_time = date("H:i:s", strtotime($params['ReservationsSearch']['booking_start_time']));
            $dataProvider->query->andFilterWhere(['booking_start_time' => $booking_start_time]);
        }

        return $dataProvider;
    }

    public function RestaurantWiseSearch($params)
    {
        $query = Reservations::find()->where(['restaurant_id' => $params['restaurant_id']]);

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
            'floor_id' => $this->floor_id,
            'table_id' => $this->table_id,
            'date' => $this->date,
            // 'contact_no' => $this->contact_no,
            // 'booking_start_time' => $this->booking_start_time,
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

        /*    andFilterWhere(['like', 'first_name', $this->first_name])
        ->andFilterWhere(['like', 'last_name', $this->last_name])
        ->andFilterWhere(['like', 'email', $this->email])*/
        $query->andFilterWhere(['like', 'pickup_drop', $this->pickup_drop])
            ->andFilterWhere(['like', 'pickup_location', $this->pickup_location])
            ->andFilterWhere(['like', 'drop_location', $this->drop_location])
            ->andFilterWhere(['like', 'special_comment', $this->special_comment]);

        if (!empty($params['ReservationsSearch']) && !empty($params['ReservationsSearch']['booking_start_time'])) {
            $booking_start_time = date("H:i:s", strtotime($params['ReservationsSearch']['booking_start_time']));
            $dataProvider->query->andFilterWhere(['booking_start_time' => $booking_start_time]);
        }

        return $dataProvider;
    }

    public function forntendSearch($params)
    {
        $query = Reservations::find()->where("status !=" . Yii::$app->params['reservation_status_value']['deleted'] . " AND user_id = " . Yii::$app->user->id);

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
            'floor_id' => $this->floor_id,
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
            //'tag_id' => $this->tag_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        //p($this->tag_id);
        $query->andFilterWhere(['like', 'pickup_drop', $this->pickup_drop])
            ->andFilterWhere(['like', 'pickup_location', $this->pickup_location])
            ->andFilterWhere(['like', 'drop_location', $this->drop_location])
            ->andFilterWhere(['like', 'special_comment', $this->special_comment]);
        // ->andFilterWhere(['like', "(',' + RTRIM(tag_id) + ',')", "'%,'+" . $this->tag_id . "+',%'"]);

        // ->andFilterWhere("(',' + RTRIM(tag_id) + ',') LIKE '%,' + " . $this->tag_id . " + ',%'");

        //  ->andFilterWhere(['like', 'tag_id', $this->tag_id]);

        if (!empty($params['ReservationsSearch']) && !empty($params['ReservationsSearch']['booking_start_time'])) {
            $booking_start_time = date("H:i:s", strtotime($params['ReservationsSearch']['booking_start_time']));
            $dataProvider->query->andFilterWhere(['booking_start_time' => $booking_start_time]);
            // $dataProvider->query->andFilterWhere("(',' + RTRIM(tag_id) + ',') LIKE '%,'"+".$this->tag_id."+"',%'");

        }
        return $dataProvider;

    }
}
/*if (!empty($params['ReservationsSearch']) && !empty($params['ReservationsSearch']['tag_id'])) {
// $condition = "['OR',['>',LOCATE('," . $this->tag_id . ",', CONCAT(',',tag_id,',')),'0'],['>',LOCATE('," . $this->tag_id . ",', CONCAT(',',tag_id,',')),0]]";
//eval("\$condition = $condition;");
//$get_string = "(etag_id LIKE '%," . $this->tag_id . ",%') OR (tag_id LIKE '" . $this->tag_id . ",%') OR (tag_id LIKE '%," . $this->tag_id . "') OR (tag_id = " . $this->tag_id . ")";
// parse_str($get_string, $get_array);
// p($get_array);
$like1 = addslashes("%," . $this->tag_id . ",%");
$like2 = addslashes($this->tag_id . ",%");
$like3 = addslashes("%," . $this->tag_id);

//  $dataProvider->query->andFilterWhere(["OR", ["LIKE", "tsag_id", $like1], ["LIKE", "tag_id", $like2], ["LIKE", "tag_id", $like3], ["=", "tag_id", $this->tag_id]]);
//["(LOCATE(','" . $this->tag_id . "','", "CONCAT(',',tag_id, ',')) > 0 OR LOCATE(','" . $this->tag_id . "','", "CONCAT(',', tag_id, ',')) > 0)"];
}/*
return $dataProvider;

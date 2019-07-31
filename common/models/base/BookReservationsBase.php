<?php

namespace common\models\base;

use Yii;
use common\models\Reservations;
use common\models\RestaurantFloors;
use common\models\RestaurantTables;

/**
 * This is the model class for table "book_reservations".
*
    * @property integer $id
    * @property integer $reservation_id
    * @property integer $floor_id
    * @property integer $table_id
    * @property integer $person_count_per_table
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Reservations $reservation
            * @property RestaurantFloors $floor
            * @property RestaurantTables $table
    */
class BookReservationsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'book_reservations';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['reservation_id', 'floor_id', 'table_id'], 'required'],
            [['reservation_id', 'floor_id', 'table_id', 'person_count_per_table'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['reservation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reservations::className(), 'targetAttribute' => ['reservation_id' => 'id']],
            [['floor_id'], 'exist', 'skipOnError' => true, 'targetClass' => RestaurantFloors::className(), 'targetAttribute' => ['floor_id' => 'id']],
            [['table_id'], 'exist', 'skipOnError' => true, 'targetClass' => RestaurantTables::className(), 'targetAttribute' => ['table_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'reservation_id' => Yii::t('app', 'Reservation ID'),
    'floor_id' => Yii::t('app', 'Floor ID'),
    'table_id' => Yii::t('app', 'Table ID'),
    'person_count_per_table' => Yii::t('app', 'Person Count Per Table'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getReservation()
    {
    return $this->hasOne(Reservations::className(), ['id' => 'reservation_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getFloor()
    {
    return $this->hasOne(RestaurantFloors::className(), ['id' => 'floor_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTable()
    {
    return $this->hasOne(RestaurantTables::className(), ['id' => 'table_id']);
    }
}
<?php

namespace common\models;

use common\models\BookReservations;

class BookReservations extends \common\models\base\BookReservationsBase
{
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));
        return parent::beforeSave($insert);
    }

    public function get_floor($reservation_id)
    {
        $floor = BookReservations::find()->select(["distinct(floor_id)"])->where(['reservation_id' => $reservation_id])->one();
        return !empty($floor) ? $floor['floor_id'] : "-";
    }

    public function get_table($reservation_id)
    {
        $tables = BookReservations::find()->select("GROUP_CONCAT(table_id) AS tables")->where(['reservation_id' => $reservation_id])->asArray()->all();
        return !empty($tables[0]['tables']) ? $tables[0]['tables'] : "-";

    }
}

<?php

namespace common\models;
use Yii;
use yii\helpers\ArrayHelper;
use common\models\RestaurantFloors;
use common\models\RestaurantMenu;
use common\models\RestaurantTables;
use common\models\RestaurantWorkingHours;
use common\models\RestaurantMealTimes;

class Restaurants extends \common\models\base\RestaurantsBase
{
    public static function tableName()
{
return 'restaurants';
}

/**
* @inheritdoc
*/
  public function beforeSave($insert) {
        $user_id = Yii::$app->user->id;
        if ($this->isNewRecord) {
            $this->setAttribute('created_by',$user_id);
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));
        $this->setAttribute('updated_by',$user_id);

        return parent::beforeSave($insert);
    }
    public static function RestaurantsDropDown(){
        //->where(['status'=>Yii::$app->params['department_active_status']])
        return ArrayHelper::map(Restaurants::find()->where(['status'=>'1'])->orderBy('name')->asArray()->all(),'id','name');
    }
public function rules()
{
        return [
            [['name', 'address', 'contact_no','email','max_stay_time_after_reservation','description'], 'required'],
            [['description'],'string','max'=>100],
            [['email'],'email'],
             ['email','validateEmail'],
            ['contact_no', 'is10NumbersOnly'],
            [['description', 'address'], 'string'],
            [['pincode', 'contact_no', 'status'], 'integer'],
            [['lattitude', 'longitude'], 'number'],
            [['max_stay_time_after_reservation','created_by','updated_by','photo','created_at', 'updated_at'], 'safe'],
            [['name', 'city', 'country', 'website', 'email'], 'string', 'max' => 255],
            [['state'], 'string', 'max' => 250],
        ];
}
public function is10NumbersOnly($attribute)
{
    if (!preg_match('/^[0-9]{10}$/', $this->$attribute)) {
        $this->addError($attribute, 'Invalid contact Number.');
    }
}
    public function validateEmail() {
        $ASvalidateemail = Restaurants::find()->where('email = "' . $this->email . '" and id != "' . $this->id . '"')->all();
        if (!empty($ASvalidateemail)) {
            $this->addError('email', 'This email address already registered.');
            return true;
        }
    }

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'name' => 'Name',
    'description' => 'Description',
    'photo' => "Photo",
    'address' => 'Address',
    'city' => 'City',
    'state' => 'State',
    'country' => 'Country',
    'pincode' => 'Pincode',
    'lattitude' => 'Lattitude',
    'longitude' => 'Longitude',
    'website' => 'Website',
    'contact_no' => 'Contact No',
    'email' => 'Email',
    'max_stay_time_after_reservation' => 'Max Stay Time After Reservation',
    'status' => 'Status',
    'created_by' => 'Created By',
    'updated_by' => 'Updated By',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurantFloorss()
    {
    return $this->hasMany(RestaurantFloors::className(), ['restaurant_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurantMenus()
    {
    return $this->hasMany(RestaurantMenu::className(), ['restaurant_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurantTables()
    {
    return $this->hasMany(RestaurantTables::className(), ['restaurant_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurantWorkingHours()
    {
    return $this->hasMany(RestaurantWorkingHours::className(), ['restaurant_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurentMealTimes()
    {
    return $this->hasMany(RestaurantMealTimes::className(), ['restaurant_id' => 'id']);
    }
}
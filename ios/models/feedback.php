<?php
namespace app\models;
use yii\db\ActiveRecord;
//use app\models\Student;
use yii;
class Feedback extends ActiveRecord{


    public  static function  tableName()
    {
        return 'feedback';
    }


//    public function getOrders()
//    {
//        return $this->hasOne(student::className(),['uid'=>'uid']);
//    }

}

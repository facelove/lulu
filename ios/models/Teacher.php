<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii;
class Teacher extends ActiveRecord{

    const STATUS_ACTIVE= 28;


    public  static function  tableName()
    {
        return 'base_teacher';
    }
}
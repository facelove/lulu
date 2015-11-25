<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii;
class student extends ActiveRecord{

    public  static function  tableName()
    {
        return 'base_student';
    }


}

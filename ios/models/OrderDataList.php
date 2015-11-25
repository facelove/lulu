<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii;

//接口参数
class Order extends ActiveRecord{
    public  static function  tableName()
    {
        return 'orderInfo';
    }
}
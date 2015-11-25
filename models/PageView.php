<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii;
use app\models\CardData;

//接口参数
class PageView extends ActiveRecord{

    public  static function  tableName()
    {
        return 'editView';
    }

    public  function getOrders()
    {
        return $this->hasMany(CardData::className(),['dataid'=>'dataid']);
    }

}
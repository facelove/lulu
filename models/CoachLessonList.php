<?php
/**
 * Created by PhpStorm.
 * User: OX
 * Date: 15/11/19
 * Time: 下午4:47
 */
namespace app\models;
use yii\db\ActiveRecord;
use yii;
//接口参数
class CoachLessonList extends ActiveRecord{
    public static function tableName()
    {
        return 'base_teacherLesson';
    }
    public  function getOrders()
    {
        return $this->hasMany(Product::className(),['o_code'=>'code']);
    }

}
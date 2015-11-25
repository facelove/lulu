<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii;

//接口参数
class orderFixHistory extends ActiveRecord{
    public $id;//订单id
    public $coachType;//辅导类型：
    public $title;//订单title
    public $timeLong;   //时长
    public $price;      //小时单价
    public $allTimeLong;   //专题课程时长（如一天，一个月）
    public $allPrice;       //专题课程总价
    public $subject;    //科目
    public $startTime;  //订单有效开始时间
    public $youhuijuan;//订单有效结束时间
    public $address;//辅导地点经纬度
    public $limitNumber;//限制人数
    public $jionNumber;//参与人数
    public $info;//订单描述

    public  static function  isEquelValue($orderValue,$value)
    {
        if($orderValue==$value)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
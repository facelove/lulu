<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii;

//接口参数
class OrderInfo extends ActiveRecord{

    public $id;//订单id
    public $title;//订单title
    public $uid;//发布者UID
    public $orderType;//订单类型
    public $limitNumber;//限制人数
    public $jionNumber;//参与人数
    public $subject;    //科目

    public $timeLong;   //时长
    public $price;      //小时单价
    public $allTimeLong;   //专题课程时长（如一天，一个月）
    public $allPrice;      //专题课程总价

    public $directType;//是否定向订单（只有学生才有）
    public $directTelephone;//定向老师电话（只有学生才有）
    public $directName;//定向老师name（只有学生才有）
    public $directInfo;//是否定向详情（只有学生才有）

    public $startTime;  //订单有效开始时间
    public $youhuijuan;//订单有效结束时间
    public $address;//辅导地点经纬度
    public $coachType;//辅导类型：一对一，一对多，




    public  static function  tableName()
    {
        return 'O_orderInfo';
    }



}
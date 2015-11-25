<?php
namespace app\controllers;
use app\controllers;
use app\models\UserLogin;
use app\models\Student;
use app\models\Teacher;
use app\models\Organization;
use app\models\Product;
/*
 *  public $id;//订单id
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
    public $coachType;//辅导类型：
 */

//接口参数
class PublicProduct extends Controller
{
    public  function actionAddProduct()
    {

    }

    function makeProduct()
    {

        $coachType=\BaseFunction::getParam('$coachType',$_POST);
        switch($coachType)
        {
            case 1 :
            case 3 :
            {
                $this->addFindOneTeacher_Or_OneStudent($coachType);
                break;
            }

            case 2 :
            {
                $this->addFindSpecialTeacher($coachType);
                break;
            }
            case 5 :
            case 7 :
            case 8 :
            case 9 :
            {
                $this->addFindSomeStudents($coachType);
                break;
            }
            case 4:
            case 6:
            {
                $this->addFindSomeTeachers($coachType);
            }
                default:
                    {
                        break;
                    }

        }
    }
    function  addFindOneTeacher_Or_OneStudent($orderType)
    {//1，3 找一个学生或者找一个老师
        $query=new Product;
        $query->orderType=$orderType;
        $query->address=\BaseFunction::getParam('address',$_POST);
        $query->title=\BaseFunction::getParam('title',$_POST);
        $query->grade=\BaseFunction::getParam('grade',$_POST);
        $query->uid=\BaseFunction::getParam('uid',$_POST);
        $query->subject=\BaseFunction::getParam('subject',$_POST);
        $query->timeLong=\BaseFunction::getParam('timeLong',$_POST);
        $query->price=\BaseFunction::getParam('price',$_POST);
        $query->limitNumber=1;
        $query->jionNumber=1;
        $query->youhuijuan=\BaseFunction::getParam('youhuijuan',$_POST);
        $query->startTime=\BaseFunction::getParam('startTime',$_POST);
        $query->directType=0;
        $query->save();
    }
    function  addFindSpecialTeacher($orderType)
    {//2找特定老师
        $query=new Product;
        $query->orderType=$orderType;
        $query->title=\BaseFunction::getParam('title',$_POST);
        $query->uid=\BaseFunction::getParam('uid',$_POST);
        $query->subject=\BaseFunction::getParam('subject',$_POST);
        $query->timeLong=\BaseFunction::getParam('timeLong',$_POST);
        $query->price=\BaseFunction::getParam('price',$_POST);
        $query->limitNumber=1;
        $query->jionNumber=1;
        $query->youhuijuan=\BaseFunction::getParam('youhuijuan',$_POST);
        $query->startTime=\BaseFunction::getParam('startTime',$_POST);
        $query->address=\BaseFunction::getParam('address',$_POST);
        $query->directType=1;
        $query->directInfo=\BaseFunction::getParam('directInfo',$_POST);
        $query->directName=\BaseFunction::getParam('directName',$_POST);
        $query->directTelephone=\BaseFunction::getParam('directTelephone',$_POST);
        $query->save();
    }

    function  addFindSomeStudents($orderType)
    {//5。7，8，9均是 开辅导班 作业班  机构兴趣班均走此类型
        $query=new Product;
        $query->orderType=$orderType;
        $query->title=\BaseFunction::getParam('title',$_POST);
        $query->uid=\BaseFunction::getParam('uid',$_POST);
        $query->subject=\BaseFunction::getParam('subject',$_POST);
        $query->allTimeLong=\BaseFunction::getParam('allTimeLong',$_POST);
        $query->allPrice=\BaseFunction::getParam('allPrice',$_POST);
        $query->limitNumber=\BaseFunction::getParam('limitNumber',$_POST);
        $query->youhuijuan=\BaseFunction::getParam('youhuijuan',$_POST);
        $query->startTime=\BaseFunction::getParam('startTime',$_POST);
        $query->address=\BaseFunction::getParam('address',$_POST);
        $query->save();
    }
    function  addFindSomeTeachers($orderType)
    {//4，6均是 找辅导班
        $query=new Product;
        $query->orderType=$orderType;
        $query->title=\BaseFunction::getParam('title',$_POST);
        $query->uid=\BaseFunction::getParam('uid',$_POST);
        $query->youhuijuan=\BaseFunction::getParam('youhuijuan',$_POST);
        $query->address=\BaseFunction::getParam('address',$_POST);
        $query->save();
    }







}
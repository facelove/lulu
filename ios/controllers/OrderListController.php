<?php
namespace app\controllers;
use yii\base\Object;
use yii\web\Controller;
use app\models\UserLogin;
use app\models\Order;
use app\models\Student;
use app\models\Teacher;
//use app\models\OrderFixHistory;

class OrderListController extends Controller
{
    public function actionIndex()
    {
        $this->actionCreatOrder();
    }


    //生成订单//orderType
    public function actionCreatOrder()
    {
        //辅导类型
        //1.找老师一对一辅导 2.找特定老师辅导3.找学生一对一辅导4.找假期辅导5.开假期辅导6.找周末辅导7.开周末辅导8.作业辅导9机构辅导
        $coachtype=\BaseFunction::getParam('coachType',$_POST);
        $order=new Order;
        $order->id=\BaseFunction::getParam('id',$_POST);
        $order->title=\BaseFunction::getParam('title',$_POST);
        $order->suid=\BaseFunction::getParam('suid',$_POST);//学生UID

        //区分身份
        if($coachtype==1)
        {
            $order->tuid=\BaseFunction::getParam('tuid',$_POST);//老师UID
            //$order->ordertype=$coachtype;//订单类型 1.个人单，3.老师单,2个人定向预约单,4.老师专题单5,机构单
        }
        elseif($coachtype==2)
        {
            $order->tuid=\BaseFunction::getParam('tuid',$_POST);
        }
        elseif($coachtype==5)
        {
            $order->guid=\BaseFunction::getParam('guid',$_POST);//机构UID
        }
        else
        {
            \BaseFunction::returnJson('','A00001','没有此辅导类型');
        }
        //计算课程总价
        if($coachtype==1 or $coachtype==2 or $coachtype==3)
        {
                $price=\BaseFunction::getParam('price',$_POST);;      //价格
                $long=\BaseFunction::getParam('timeLong',$_POST);;
                $order->price=$price;
                $order->timeLong=$long;
                $order->limitNumber=1;//参与人数


        }
        elseif($coachtype>=4 and $coachtype<=9)
        {
            $order->allPrice=\BaseFunction::getParam('allPrice',$_POST);
            $order->allTimeLong=\BaseFunction::getParam('timeAllLong',$_POST);
            $order->limitNumber=\BaseFunction::getParam('limitNumber',$_POST);//参与人数
        }
        else
        {
            \BaseFunction::returnJson('','A00001','本版本没有此类课程');
        }
        $order->startTime=time();
        if(isset($_POST['youhuijuan']))
        {
            $youhuijuan=\BaseFunction::getExistParam('youhuijuan',$_POST);
        }
        $order->address=\BaseFunction::getParam('address',$_POST);//辅导地点经纬度
        $order->jionNumber=1;//参与人数
        if(isset($_POST['info']))
        {
            $order->info=$_POST['info'];//订单描述
        }
        $order->coachType=$_POST['coachType'];
        $order->state=2;//生成订单就等待确认

        $order->save();
        \BaseFunction::returnJson($order);

    }
    //获取订单
    public function actionGetOrder()
    {
        $id=\BaseFunction::getParam('id');
        $query=Order::find()
            ->where(['id'=>$id])
            ->one();
        if(!empty($query))
        {
            \BaseFunction::returnJson($query);
        }
        else
        {
            \BaseFunction::returnJson('','A00007','没有此订单');
        }

    }


    //修改订单状态   POST state
    public function actionFixOrder()
    {
        $id=\BaseFunction::getParam('id');
        $state=\BaseFunction::getParam('state');
        $query=Order::find()
            ->where(['id'=>$id])
            ->one();

        if(!empty($query))
        {
            $query->state=$state;
            $query->save();
        }
        else
        {
            \BaseFunction::returnJson('','A00007','此订单已不存在');
        }
    }
    //删除订单
    public  function actionDeleteOrder()
    {
        $id=\BaseFunction::getParam('id');
        $query=Order::find()
            ->where(['id'=>$id])
            ->one();

        if(!empty($query))
        {
            $query->delete();
            \BaseFunction::returnJson('');
        }
        else
        {
            \BaseFunction::returnJson('','A00007','此订单已不存在');
        }
    }

}
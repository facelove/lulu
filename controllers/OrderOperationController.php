<?php
namespace app\controllers;
use app\controllers;
use Yii;
use app\models\UserLogin;
use app\models\Student;
use app\models\Teacher;
use app\models\Organization;
use app\models\Order;
use app\models\OrderInfo;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtmlPurifier;
use yii\validators\BooleanValidator;

//接口参数 action=1发布订单 2取消订单 3修改订单4查询订单
//生成订单// uid role coachType o_title o_des o_role price unit count  limitNumber jionNumber subject ,address latitude longitude
//取消订单   uid code
//修改订单   只支持修改限定人数，地址
//辅导类型
//1.找老师一对一辅导 2.找特定老师辅导3.找学生一对一辅导4.找假期辅导5.开假期辅导6.找周末辅导7.开周末辅导8.作业辅导9机构辅导
class OrderOperation extends Controller
{
    public function actionIndex()
    {
        $action=BaseFunction::getParam('action',true,$_POST);
        $this->checkParams($action,$_POST);
        switch($action)
        {
            case 1:
                $this->actionCreatOrder();
                break;
            case 2:
                $this->actionDeleteOrder();
                break;
            case 3:
                $this->actionModifyOrder();
                break;
            case 4:
                $this->actionFindOrder();
                break;
            default:
                break;
        }

    }

    public function actionCreatOrder()
    {
        $post=Yii::$app->request->post();
        $classid=strval(time());
        $code=md5($classid.'123',true);
        $connection=Yii::app()->db;
        try
        {
            $transaction=$connection->beginTransaction();//事物开始
            $order=new Order();
            $order=\BaseFunction::fileArrayToModel($post,$order);
            $order->addtime=time();
            $order->classid=$classid;
            $order->o_status=1;
            $order->o_code=$code;
            $order->o_role=1;
            $order->save();

            $OrderInfo=new OrderInfo();
            $order=\BaseFunction::fileArrayToModel($post,$OrderInfo);
            if(intval($order->coachType)==1)
            {
                $order->limitNumber=1;
                $order->jionNumber=1;
            }
            $OrderInfo->code=$code;
            $OrderInfo->save();
            $transaction->commit();//事物结束
            \BaseFunction::returnJson('');
        }
        catch(Exception $e)
        {
            $transaction->rollback();//回滚函数
            $rs['info']=$e->getMessage();//异常信息
            \BaseFunction::returnJson('','A00030',json_encode($rs));

        }
    }

    public function actionDeleteOrder()
    {
        $uid=\BaseFunction::getParam('uid',true,$_POST);
        $code=\BaseFunction::getParam('code',false,$_POST);
        $connection=Yii::app()->db;
        try
        {
            $transaction=$connection->beginTransaction();//事物开始
            $order=Order::find()
                ->where(['uid'=>$uid,'code'=>$code])
                ->one();
            if(empty($order))
            {
                $result=2;
            }
            else
            {
                $order->o_status=7;
                $order->save();
            }
            $transaction->commit();//事物结束
            $result=1;
        }
        catch(Exception $e)
        {
            $transaction->rollback();//回滚函数
            $rs['info']=$e->getMessage();//异常信息
           $result=3;
        }

        if($result==1)
        {
            \BaseFunction::returnJson('');
        }
        elseif($result==2)
        {
            \BaseFunction::returnJson('','A00031','数据库没有此数据');
        }
        elseif($result==3)
        {
            \BaseFunction::returnJson('','A00030',json_encode($rs));
        }

    }

    public function actionModifyOrder()
    {

        $uid=\BaseFunction::getParam('uid',true,$_POST);
        $code=\BaseFunction::getParam('code',false,$_POST);
        $connection=Yii::app()->db;
        $result=1;
        try
        {
            $transaction=$connection->beginTransaction();//事物开始
            $order=Order::find()
            ->where(['uid'=>$uid,'code'=>$code])
            ->one();
             if(!empty($order))
             {
                 $OrderInfo=OrderInfo::find()
                     ->where(['uid'=>$uid,'code'=>$code])
                     ->one();
                 if(empty($order))
                 {
                     $result=2;

                 }
                 else
                 {
                     if(isset($_POST['limitNumber']))
                     {
                         $limit=intval($_POST['limitNumber']);
                         $OrderInfo->limitNumber=7;
                     }
                     if(isset($_POST['address']))
                     {
                         $address=strval($_POST['address']);
                     }
                     if(isset($_POST['latitude']))
                     {
                         $latitude=floatval($_POST['latitude']);
                     }
                     if(isset($_POST['longitude']))
                     {
                         $longitude=floatval($_POST['longitude']);
                     }
                     $OrderInfo->save();

                     $result=1;
                 }
             }
            else
            {
                $result=2;
            }
            $transaction->commit();//事物结束
        }
        catch(Exception $e)
        {
            $transaction->rollback();//回滚函数
            $rs['info']=$e->getMessage();//异常信息
            $result==3;
        }

        if($result==1)
        {
            \BaseFunction::returnJson('');
        }
        elseif($result==2)
        {
            \BaseFunction::returnJson('','A00031','数据库没有此数据');
        }
        elseif($result==3)
        {
            \BaseFunction::returnJson('','A00030',json_encode($rs));
        }
    }

    public function actionFindOrder()
    {
        $uid=\BaseFunction::getParam('uid',true,$_POST);
        $code=\BaseFunction::getParam('code',false,$_POST);
        $connection=Yii::app()->db;
        $result=1;
        try
        {
            $transaction=$connection->beginTransaction();//事物开始
            $order=Order::find()
                ->with('orders')
                ->where(['uid'=>$uid,'code'=>$code])
                ->one();
            $transaction->commit();//事物结束
        }
        catch(Exception $e)
        {
            $transaction->rollback();//回滚函数
            $rs['info']=$e->getMessage();//异常信息
            $result==3;
        }

        if($result==1)
        {
            \BaseFunction::returnJson('');
        }
        elseif($result==2)
        {
            \BaseFunction::returnJson('','A00031','数据库没有此数据');
        }
        elseif($result==3)
        {
            \BaseFunction::returnJson('','A00030',json_encode($rs));
        }

    }

    private  function checkParams($action,$params)
    {
        if($action==1)
        {
            $rolekeys=array('uid','role','coachType','latitude','longitude','address',
                'o_title','o_des','o_role','price','unit','count','limitNumber','jionNumber','subject','grade');
        }
        foreach($rolekeys as $key )
        {
            if(!isset($params[$key]))
            {
                \BaseFunction::returnJson('','A00001','缺少参数'.$key);
            }
        }
    }
}
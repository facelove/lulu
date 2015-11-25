<?php
namespace app\controllers;
use app\controllers;
use Yii;
use app\models\UserLogin;
use app\models\Student;
use app\models\Teacher;
use app\models\Organization;
use app\models\OrderDataList;
use app\models\Product;
//接口参数 action=1增 2删3 修改4查询
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
            default:
                break;
        }

    }


    //生成订单// uid role coachType o_title o_des o_role price unit count  limitNumber jionNumber subject ,address latitude longitude
    public function actionCreatOrder()
    {

        $post=Yii::$app->request->post();
        $classid=strval(time());
        $code=md5($classid.'123',true);

        $order=new OrderDataList();

        $order=\BaseFunction::fileArrayToModel($post,$order);
        $order->addtime=time();
        $order->classid=$classid;
        $order->o_status=1;
        $order->o_code=$code;
        $order->o_role=1;
        $order->save();

        $product=new Product();
        $order=\BaseFunction::fileArrayToModel($post,$product);
        $product->code=$code;



//        if(intval($order->coachType)==1)
//        {
//            $order->jionNumber=1;//参与人数
//            $order->limitNumber=1;
//        }
        //辅导类型
        //1.找老师一对一辅导 2.找特定老师辅导3.找学生一对一辅导4.找假期辅导5.开假期辅导6.找周末辅导7.开周末辅导8.作业辅导9机构辅导


    }
    private  function checkParams($action,$params)
    {
        if($action==1)
        {
            $rolekeys=array('uid','role','coachType','latitude','longitude','address',
                'o_title','o_des','o_role','price','unit','count','limitNumber','jionNumber','subject','grade');
        }
        elseif($action==2)
        {
            $rolekeys=array('age','sex','address','latitude','longitude','image','city','sfzid','jiaoling','zhicheng','isstudent','xuexiao','biyexuexiao');
        }
        else
        {
            $rolekeys=array('age','sex','address','latitude','longitude','image','city','sfzid','feature','linkman','telephone','ensure');

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
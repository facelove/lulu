<?php
namespace app\controllers;
use yii\web\Controller;
use app\models\UserLogin;
use app\models\Student;
use app\models\Teacher;
use app\models\Organization;


//接口参数   action=1: uid，password
//          action=2:token

class LoginController extends Controller
{
    public  function actionIndex()
    {
        $action=\BaseFunction::getParam('action',true,$_POST);
        if($action==1)
        {
            $this->loginWithUid();
        }
        elseif($action==2)
        {
            $this->loginWithToken();
        }

    }

      function  loginWithUid()
    {
        $uid=\BaseFunction::getParam('uid');
        $user=UserLogin::isexist($uid);
        $this->callBackTheAction($user,$uid);
    }
    function  loginWithToken()
    {
        $token=\BaseFunction::getParam('token',false,$_POST);
        $user=UserLogin::isexistToken($token);
        if($user!=false)
        {
            \BaseFunction::returnJson('');
        }
        else
        {
            \BaseFunction::returnJson('','A00001','鉴权失败');
        }


    }

    function callBackTheAction($user,$uid)
    {
        if($user!=false)
        {
            $password=\BaseFunction::getParam('password');
            $passwordMd5=md5(trim($password));

            if($user->password===$passwordMd5)
            {
                //用户存在
                if($user->role==1)
                {
                    $query=Student::find()
                        ->where(['uid'=>$uid])
                        ->one();
                    $user->lastLoginTime=time();
                    $user->save();
                    \BaseFunction::returnModleJson($query);
                }
                elseif($user->role==2)
                {
                    $query=Teacher::find()
                        ->where(['uid'=>$uid])
                        ->one();
                    $user->lastLoginTime=time();
                    $user->save();
                    \BaseFunction::returnModleJson($query);
                }
                elseif($user->role==3)
                {
                    $query=Organization::find()
                        ->where(['uid'=>$uid])
                        ->one();
                    $user->lastLoginTime=time();
                    $user->save();
                    \BaseFunction::returnModleJson($query);
                }
                else
                {
                    \BaseFunction::returnJson('','A00004','数据库出错');
                }
            }
            else
            {
                //用户密码错误
                \BaseFunction::returnJson('','A00003','密码错误');
            }
        }
        else
        {
            \BaseFunction::returnJson('','A00003','没有此用户');
        }
    }

}
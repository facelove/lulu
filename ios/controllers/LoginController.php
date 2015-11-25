<?php
namespace app\controllers;
use yii\web\Controller;
use app\models\UserLogin;
use app\models\Student;
use app\models\Teacher;
use app\models\Organization;


//接口参数    uid，password
class LoginController extends Controller
{
    public  function actionIndex()
    {
        $uid=\BaseFunction::getParam('uid');
        $password=\BaseFunction::getParam('password');
        $passwordMd5=md5(trim($password));

        $user=UserLogin::isexist($uid);
        if($user!=false)
        {
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
                    \BaseFunction::returnJson('','A00004','没有这一类用户');
                }
            }
            else
            {
                //用户密码错误
                \BaseFunction::returnJson('','A00003','密码错误');
            }
        }

    }


}
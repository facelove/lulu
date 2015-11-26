<?php
namespace app\controllers;
use yii\web\Controller;
use app\models\UserLogin;
use app\models\Student;
use app\models\Teacher;
use app\models\Organization;

//参数action=1查找某年级某科目老师
class FindController extends Controller
{
    public  function actionIndex()
    { //uid subject grade
        $action=\BaseFunction::getParam('action',true);
        if($action==1)
        {
            
        }
    }

}
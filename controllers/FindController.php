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
        {//action=1查找某年级某科目老师
            $grade=\BaseFunction::getParam('grade',true);
            $subject=\BaseFunction::getParam('subject',true);
            $lesson=TeacherLesson::find()
                ->with('teacher')
                ->where(['grade'=>$grade,'subject'=>$subject])
                ->all();
            foreach($lesson as $one)
            {
                $teacher=$one->teacher;
                $array[]=array(
                    't'=>ArrayHelper::toArray($teacher),
                    'l'=>ArrayHelper::toArray($one),
                );
            }
            \BaseFunction::returnJson($array);
        }
        elseif($action==2)
        {//查找某科目老师
            $subject=\BaseFunction::getParam('subject',true);
            $lesson=TeacherLesson::find()
                ->with('teacher')
                ->where(['subject'=>$subject])
                ->all();
            foreach($lesson as $one)
            {
                $teacher=$one->teacher;
                $array[]=array(
                    't'=>ArrayHelper::toArray($teacher),
                    'l'=>ArrayHelper::toArray($one),
                );
            }
            \BaseFunction::returnJson($array);
        }
        elseif($action==3)
        {
            //查找某课程的机构
            $subject=\BaseFunction::getParam('subject',true);
            $lesson=TeacherLesson::find()
                ->with('organization')
                ->where(['subject'=>$subject])
                ->all();
            foreach($lesson as $one)
            {
                $teacher=$one->organization;
                $array[]=array(
                    'o'=>ArrayHelper::toArray($teacher),
                    'l'=>ArrayHelper::toArray($one),
                );
            }
            \BaseFunction::returnJson($array);

        }


    }

}
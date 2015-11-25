<?php
namespace app\controllers;
use Yii;
use yii\web\Request;
use yii\web\Controller;
use app\models\Student;
use app\models\Teacher;
use app\models\Organization;
use app\models\UserLogin;
use app\models\CoachLessonList;
//接口参数       POST方法
/* 学生              老师                  机构
 * role             role                  role
 *                  lesson                lesson
 * age              age
 * sex              sex
 * address          adress              adress
 * latitude         latitude            latitude
 * longitude        longitude           longitude
 * image            image               image
 * city             city                city
 * nianji           sfzid               sfzid
 *                  jiaoling            feature
 *                  zhicheng            linkman
 *                  isstudent           telephone
 *                  xuexiao             ensure
 *                  biyexuexiao         image1
 *                                      image2
 *                                      image3
 *                                      image4
 *                                      image5
 */
class CompleteUserInfoController extends Controller
{
    public function actionIndex()
    {
        $post=Yii::$app->request->post();
         //安全检查
        if(!isset($post['role']))
        {
            \BaseFunction::returnJson('','A00001','缺少参数role');
        }
        else
        {
            $role=$post['role'];
            $this->checkParams($role,$post);
        }
        //写入数据库
        if($role==1)
        {
            $student=new Student;
            $student->age=$post['age'];
            $student->sex=$post['sex'];
            $student->address=$post['address'];
            $student->latitude=$post['latitude'];
            $student->longitude=$post['longitude'];
            $student->image=$post['image'];
            $student->city=$post['city'];
            $student->nianji=$post['nianji'];
            $student->save();
        }
        elseif($role==2)
        {
            $teacher=new Teacher;
            $teacher->age=$post['age'];
            $teacher->sex=$post['sex'];
            $teacher->address=$post['address'];
            $teacher->latitude=$post['latitude'];
            $teacher->longitude=$post['longitude'];
            $teacher->image=$post['image'];
            $teacher->city=$post['city'];
            $teacher->sfzid=$post['sfzid'];
            $teacher->jiaoling=$post['jiaoling'];
            $teacher->zhicheng=$post['zhicheng'];
            $teacher->isstudent=$post['isstudent'];
            $teacher->xuexiao=$post['xuexiao'];
            $teacher->biyuexuexiao=$post['biyexuexiao'];
            $teacher->activestate=1;//正在审核
            $teacher->save();

            $lessonString=\BaseFunction::getParam('lesson');
            $lessonArray=json_decode(urldecode($lessonString),true);
            $lessonListObj=new CoachLessonList();
            $lessonList=\BaseFunction::fileArrayToModel($lessonArray,$lessonListObj);
            $lessonListObj->save();






        }
        elseif($role==3)
        {
            $organization=new Organization;
            $organization->age=$post['age'];
            $organization->sex=$post['sex'];
            $organization->address=$post['address'];
            $organization->latitude=$post['latitude'];
            $organization->longitude=$post['longitude'];
            $organization->image=$post['image'];
            $organization->city=$post['city'];
            $organization->sfzid=$post['sfzid'];
            $organization->feature=$post['feature'];
            $organization->linkman=$post['linkman'];
            $organization->telephone=$post['telephone'];
            $organization->ensure=$post['ensure'];
            $organization->activestate=1;//正在审核
            $organization->save();
            $lessonString=\BaseFunction::getParam('lesson');
            $lessonArray=json_decode(urldecode($lessonString),true);
            $lessonListObj=new CoachLessonList();
            $lessonList=\BaseFunction::fileArrayToModel($lessonArray,$lessonListObj);
            $lessonListObj->save();

        }
        \BaseFunction::returnJson('');
    }

    private   function saveKemuToDB($subject,$grade,$uid)
    {
        $query= new CoachLessonList;
        $query->subject=$subject;
        $query->grade=$grade;
        $query->uid=$uid;
        $query->save();
    }
    private  function checkParams($role,$params)
    {
        if($role==1)
        {
            $rolekeys=array('age','sex','address','latitude','longitude','image','city','nianji');
        }
        elseif($role==2)
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
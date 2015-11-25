<?php
namespace app\controllers;
use yii\web\Request;
use yii\web\Controller;
use app\models\Student;
use app\models\Teacher;
use app\models\Organization;
use app\models\UserLogin;


//接口参数    name，password，role   POST方法
class RegisterController extends Controller
{
    public function actionIndex()
    {
        $uid=\BaseFunction::getParam('uid',true,$_POST);
        $name=\BaseFunction::getParam('name',$_POST);
        $password=\BaseFunction::getParam('password',$_POST);
        $role=\BaseFunction::getParam('role',true,$_POST);

        if(UserLogin::isexist($uid))
        {
            \BaseFunction::returnJson('','A00001','用户已经注册');
        }


        if($role==1)
        {//学生

            $student=new Student;
            $student->uid=$uid;
            $student->name=$name;
            $student->role=$role;
            $student->save();
        }
        elseif($role==2)
        {//老师

            $teacher=new Student;
            $teacher->uid=$uid;
            $teacher->name=$name;
            $teacher->role=$role;
            $teacher->save();
        }
        elseif($role==3)
        {//机构
            $organization=new Organization;
            $organization->uid=$uid;
            $organization->name=$name;
            $organization->role=$role;
            $organization->save();
        }
        $query=new UserLogin;
        $query->uid=$uid;
        $query->password=$password;
        $query->role=$role;
        $query->hasInfo=0;
        $query->creatTime=time();
        $query->lastLoginTime=time();
        $query->save();
    }

    public  function hasRegister($uid)
    {
        $query=UserLogin::find()
            ->where(['uid'==$uid])
            ->one();
        if(empty($query))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public  function hasStudent($uid)
    {
        $query=Student::find()
            ->where(['uid'==$uid])
            ->one();
        if(empty($query))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function hasTeacher($uid)
    {
        $query=Teacher::find()
            ->where(['uid'==$uid])
            ->one();
        if(empty($query))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    public function hasOrganization($uid)
    {
        $query=Organization::find()
            ->where(['uid'==$uid])
            ->one();
        if(empty($query))
        {
            return false;
        }
        else
        {
            return true;
        }
    }



    public  function actionResetPassword()
    {
        $name=\BaseFunction::getParam('name');
        $password=\BaseFunction::getParam('password');
        $query=UserLogin::find()
            ->where(['name'=>$name])
            ->one();
        if(!empty($query))
        {
            $query->password=md5(trim($password));
            $query->save();
            \BaseFunction::returnJson('');
        }
        else
        {
            \BaseFunction::returnJson('','A00001','没有此用户');
        }


    }
}

/*
 * if(isset($_POST["action"]) and $_POST["action"]=="register"){
	$user = "";
	$user["password"] = md5(trim($_POST["pass1"]));
	$user["email"] = trim($_POST["email"]);
	$user["nickname"] = trim($_POST["nickname"]);
	$user["truename"] = trim($_POST["truename"]);
	$user["telphone"] = trim($_POST["telphone"]);
	$user["mobile"] = trim($_POST["mobile"]);
	$user["address"] = trim($_POST["address"]);
	$user["sex"] = intval(trim($_POST["gender"]));
	$g->setSql("select id from #_members");
	$g->query();
	$lines = $g->getLines();
	if($lines>0){
		$user["admin"] = 0;
	}else{
		$user["admin"] = 1;
	}
	$g->setSql("select id from #_members where email = '".$user["email"]."'");
	$g->query();
	if($g->getLines()>0){
		$g->alert(' ˝æ›ø‚¥Ê‘⁄œ‡Õ¨µƒµÁ◊”” º˛µÿ÷∑£¨«Î≥¢ ‘∆‰À˚µÁ◊”” œ‰°£','register.php');
	}else{
		$g->insertObject("#_members",$user);
		$g->alert('ª·‘±◊¢≤·≥…π¶£¨«Î…‘∫Û...','index.php');
	}

}
 * */
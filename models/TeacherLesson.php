<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii;
class TeacherLesson extends ActiveRecord{

  //  const STATUS_ACTIVE= 28;


    public  static function  tableName()
    {
        return 'U_teacherLesson';
    }
    public  function getTeacher()
    {
        return $this->hasOne(Teacher::className(), ['uid' => 'uid']);
    }
    public  function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['uid' => 'uid']);
    }
}
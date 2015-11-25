<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii;
class userLogin extends ActiveRecord{

    public  static function  tableName()
    {
        return 'userLogin';
    }

    public  static function  isexist($uid)
    {
        if(!empty($uid))
        {
            $query=userLogin::find()
                ->where(['uid'=>$uid])
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
        else
        {
            return false;
        }
    }


}
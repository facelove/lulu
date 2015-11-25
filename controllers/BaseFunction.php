<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 15/9/13
 * Time: 下午1:34
 */

class BaseFunction  {
    public static function getExistParam ($index,  $arr = '',$default = '',$to_int = false ) {
        if(empty($arr)) {
            $arr = $_GET;
        }

        if(!empty($arr[$index])) {
            return $to_int ? intval($arr[$index]) : $arr[$index] . '';
        } else {
            return $to_int ? 0 : '';
        }
    }

    public static function getParam ($index,$to_int = false, $arr = '', $default = '') {
        if(empty($arr)) {
            $arr = $_GET;
        }

        if(!empty($arr[$index])) {
            return $to_int ? intval($arr[$index]) : $arr[$index] . '';
        } else {
            BaseFunction::returnJson('','A00001','缺少参数'.$index);
        }
    }

    public static function getParamFloat ($index,$to_float = false, $arr = '', $default = '') {
        if(empty($arr)) {
            $arr = $_GET;
        }

        if(!empty($arr[$index])) {
            return $to_float ? floatval($arr[$index]) : $arr[$index] . '';
        } else {
            BaseFunction::returnJson('','A00001','缺少参数'.$index);
        }
    }


    public static function  returnJson($data, $code = 'A00000', $message = "成功")
    {
        echo json_encode(array(
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ));
        exit;
    }

    public static function  returnModleJson($data, $code = 'A00000', $message = "成功")
    {

        if(is_array($data))
        {
            $data1=BaseFunction::simplifyData($data);
        }
        else
        {
            $data1=$data->attributes;
        }


        echo json_encode(array(
            'code' => $code,
            'message' => $message,
            'data' => $data1,
        ));
        exit;
    }
    public static  function simplifyData($data)
    {
        foreach($data as $key=>$val)
        {
            $newData[$key] = $val->attributes;
        }
        return $newData;
    }

    public static  function fileArrayToModel($arry,$obj)
    {
#        $objName=get_class($obj);

        $propertys=$obj->getIterator();
        foreach($propertys as $property=>$value)
        {
            if(array_key_exists($property,$arry))
            {
                echo('<br>属性：'.$property.'存在且直为：'.$arry[$property.''].'<br>');

                $obj->$property=$arry[$property];
            }
            continue;
        }

        return $obj;
    }







}


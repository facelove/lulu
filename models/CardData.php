<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii;

//接口参数
class CardData extends ActiveRecord{
//    public $dataid;
//    public $view;
//    public $dataType;
//    public $imgURL;
//    public $openType;
//    public $superScript;
//    public $subject;
//    public $title;
//    public $description;
//    public $tuid;
//    public $suid;
//    public $guid;

    public static function tableName()
    {
        return 'base_cardData';
    }
    public static  function  makeCard($card_Data)
    {
        $card1KeyArray=array('dataid','dataType','imgURL','openType','superScript','subject');
        $card2KeyArray=array('dataid','dataType','imgURL','openType','superScript','cocoaType');
        $card3KeyArray=array('dataid','dataType','imgURL','openType','title','des','open_pid','open_url','open_view');
        $card4KeyArray=array('dataid','dataType','imgURL','openType','title','des','address');
        $card5KeyArray=array('dataid','dataType','imgURL','openType','suid');
        $card6KeyArray=array('dataid','dataType','imgURL','openType','tuid');
        $card7KeyArray=array('dataid','dataType','imgURL','openType','guid');

        switch(intval($card_Data['dataType']))
        {
            case 1:
                {
                    return CardData::doWithKeyValue($card_Data,$card1KeyArray);
                }
            break;
            case 2:
            {
                return CardData::doWithKeyValue($card_Data,$card2KeyArray);
            }
                break;
            case 3:
            {
                return CardData::doWithKeyValue($card_Data,$card3KeyArray);
            }
                break;
            case 4:
            {
                return CardData::doWithKeyValue($card_Data,$card4KeyArray);
            }
                break;
            case 5:
            {
                return CardData::doWithKeyValue($card_Data,$card5KeyArray);
            }
                break;
            case 6:
            {
                return CardData::doWithKeyValue($card_Data,$card6KeyArray);
            }
                break;
            case 7:
            {
                return CardData::doWithKeyValue($card_Data,$card7KeyArray);
            }
                break;

            default:
                break;
        }
    }

    public static function doWithKeyValue($card_Data,$cardKeyArray)
    {
        $retunArray=null;
        foreach($card_Data as $key=>$value )
        {
            foreach($cardKeyArray as $cardProperty)
            {
                if($key==$cardProperty)
                {
                    $retunArray[$key]=$value;
                }
            }
        }
        return $retunArray;
    }

}
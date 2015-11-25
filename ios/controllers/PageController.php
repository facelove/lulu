<?php
namespace app\controllers;
use yii\helpers\BaseArrayHelper;
use yii\web\Controller;
use app\models\CardData;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use app\models\PageView;
use app\models\CoachLessonList;
//参数  view（页面）
class PageController extends Controller
{
    public static function actionIndex()
    {
        $view=\BaseFunction::getParam('view');
        //获取页面card
        $query=PageView::find()
            ->With('orders')
            ->where(['view'=>$view])
            ->orderBy('row')
            ->addOrderBy('column')
            ->all();


        foreach($query as $viewdata)
        {
            $carddata=$viewdata->orders;
            $row=$viewdata->row;
            $aa=ArrayHelper::toArray($carddata);

            foreach($aa as $oneCardData)
            {
                if(empty($new[$row]))
                {
                    $new[$row]=array(
                        'row'=>$row,
                        'card'=>$viewdata->card,
                        'height'=>$viewdata->height,
                        'data'=>array(CardData::makeCard($oneCardData))
                    );
                }
                else
                {
                    array_push($new[$row]['data'],CardData::makeCard($oneCardData));
                }
            }
        }
       \BaseFunction::returnJson($new);
    }



}

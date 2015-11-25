<?php
namespace app\controllers;
use yii\web\Controller;
use app\models\Feedback;
use app\models\Order;

//参数 uid txt telephone
class FeedbackController extends Controller
{
    public function actionIndex()
    {
        $uid=\BaseFunction::getParam('uid');
        $txt=\BaseFunction::getParam('txt');
        $phone = \BaseFunction::getParam('telephone');

        $feedback1=new Feedback;
        $feedback1->uid=$uid;
        $feedback1->txt=$txt;
        $feedback1->iphone=$phone;
        $feedback1->save();
        \BaseFunction::returnJson('');
    }
}
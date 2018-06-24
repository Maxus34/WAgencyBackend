<?php
/**
 * Created by PhpStorm.
 * User: MXS34
 * Date: 16.06.2018
 * Time: 17:33
 */

namespace app\modules\api\controllers;


use Yii;
use yii\web\{ HttpException, Controller };
use app\filters\CustomCors;
use app\models\records\{ OrderRecord, OrderItemRecord };


class CartController extends Controller
{

    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => CustomCors::class,
        ];

        return $behaviors;
    }


    /**
     * @throws HttpException
     */
    public function actionCreateOrder () {
        $orderData = Yii::$app->request->post();

        $order = new OrderRecord();
        $order -> name       = $orderData['user']['name'];
        $order -> surname    = $orderData['user']['surname'];
        $order -> patronymic = $orderData['user']['patronymic'];
        $order -> email      = $orderData['user']['email'];
        $order -> phone      = $orderData['user']['phone'];

        $order -> qty = $orderData['qty'];
        $order -> sum = $orderData['sum'];

        if($order -> save()){
            $orderItems = [];
            foreach($orderData['items'] as $item) {
                $orderItem = new OrderItemRecord();
                $orderItem -> orderId   = $order->id;
                $orderItem -> productId = $item['id'];
                $orderItem -> qtyItems  = 1;
                $orderItem -> sumItems  = $item['price'];
                $orderItem -> save();

                $orderItems[] = $orderItem;
            }

            $this->sendEmail($order, $orderItems);
        } else {
            throw new HttpException(422, json_encode($order->errors));
        }
    }


    public function sendEmail (OrderRecord $order, array $items) {
        $message = \Yii::$app->mailer->compose('order', [
            'order' => $order,
            'items' => $items,
        ]);

        $message
            ->setFrom('wagency.bot@mail.ru')
            ->setTo($order->email)
            ->send();
    }


    public function actionOptions () {
        return 'ok';
    }
}
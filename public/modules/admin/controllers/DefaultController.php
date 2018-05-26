<?php
namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\records\OrderRecord;


class DefaultController extends Controller
{
    public function actionIndex() {

        $dataProvider = new ActiveDataProvider([
            'query' => OrderRecord::find(),
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'defaultOrder' => [
                    'status' => SORT_ASC
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
}
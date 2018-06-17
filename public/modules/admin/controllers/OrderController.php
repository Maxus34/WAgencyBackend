<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\records\OrderRecord;


class OrderController extends Controller
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


    public function actionView ($id) {
        $order = OrderRecord::find()
            ->where(['id' => $id])
            ->with('items')
            ->one();

        return $this->render('view', [
            'model' => $order,
        ]);
    }


    public function actionUpdate ($id) {
        $model = $this->getModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    public function actionDelete ($id) {
        $model = $this->getModel($id);

        $model->delete();

        Yii::$app->session->setFlash('success', 'Заказ успешно удален.');

        return $this->render('index');
    }


    public function getModel ($id): OrderRecord {
        $model = $model = OrderRecord::findOne($id);
        if (empty($model)) {
            throw new \yii\web\HttpException(404, "Заказ не существует");
        }
        return $model;
    }
}
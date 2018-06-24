<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\{ Controller, UploadedFile, NotFoundHttpException };
use app\models\records\{ ProductRecord, CategoryRecord };


class ProductController extends Controller
{
    public function actionIndex () {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductRecord::find()
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }


    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView ($id) {
        $model = $this->getModel($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }


    public function actionCreate () {
        $model = new ProductRecord();

        $categories = CategoryRecord::find() -> with('childs') -> all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $file = UploadedFile::getInstanceByName('main-image');
            if (!empty($file)){
                $model->attachImage($file, true);
            }

            Yii::$app->session->setFlash('success', "Продукт \"{$model->name}\" добавлен");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => $categories
            ]);
        }
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate ($id) {
        $model = $this->getModel($id);
        $categories = CategoryRecord::find() -> with('childs') -> all();

        if ($model->load(Yii::$app->request->post()) && $model->save()){

            $file = UploadedFile::getInstanceByName('main-image');
            if (!empty($file)){
                $model->attachImage($file, true);
            }

            Yii::$app->session->setFlash('success', "Продукт \"{$model->name}\" обновлен");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories
            ]);
        }
    }


    public function actionDelete ($id) {
        $model = $this->getModel($id);

        if (!empty($model)) {
            $model -> delete();
            Yii::$app->session->setFlash('success', "Товар #{$id} успешно удален");
            return $this->redirect('index');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка удаления товара');
            return $this->redirect('index');
        }
    }

    /**
     * @param $id
     * @return ProductRecord|null
     * @throws NotFoundHttpException
     */
    protected function getModel ($id) {
        $model = ProductRecord::findOne($id);

        if (empty($model))
            throw new NotFoundHttpException();

        return $model;
    }
}
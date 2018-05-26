<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\{ Controller, UploadedFile, NotFoundHttpException };
use app\models\records\{ CategoryRecord, ChildCategoryRecord };

class ChildCategoryController extends Controller
{
    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView ($id) {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }


    /**
     * @param $parentId
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCreate ($parentId) {
        $category = CategoryRecord::findOne($parentId);

        if (empty($category))
            throw new NotFoundHttpException();

        $model  = new ChildCategoryRecord();
        $model -> catId = $parentId;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $file = UploadedFile::getInstanceByName('main-image');
            if (!empty($file)){
                $model->attachImage($file, true);
            }

            Yii::$app->session->setFlash('success', "Категория {$category->name} > {$model->name} успешно добавлена.");
            $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'category' => $category,
                'model' => $model,
            ]);
        }
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate ($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $file = UploadedFile::getInstanceByName('main-image');
            if (!empty($file)){
                $model->attachImage($file, true);
            }

            Yii::$app->session->setFlash('success', "Категория {$model->parent->name} > {$model->name} успешно добавлена.");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    /**
     * @param $id
     * @return ChildCategoryRecord|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = ChildCategoryRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
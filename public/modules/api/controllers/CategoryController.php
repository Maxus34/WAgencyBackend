<?php
namespace app\modules\api\controllers;

use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\filters\{ VerbFilter };
use app\filters\CustomCors;
use app\models\records\CategoryRecord;


class CategoryController extends ActiveController
{
    public $modelClass = CategoryRecord::class;
    public $enableCsrfValidation = false;


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => CustomCors::class,
        ];

        $behaviors['verbs'] = [
            'class'   => VerbFilter::class,
            'actions' => [
                'index'  => ['GET'],
                'view'   => ['GET'],
                'create' => ['POST'],
                'update' => ['PUT'],
                'delete' => ['DELETE'],
            ]
        ];


        return $behaviors;
    }


    public function actions()
    {
        return [];
    }


    public function actionIndex () {
        return new ActiveDataProvider([
            'query' => CategoryRecord::find()
        ]);
    }


    public function actionOptions () {
        return 'ok';
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: MXS34
 * Date: 25.05.2018
 * Time: 13:30
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\forms\LoginForm;


class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function actionLogin () {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    public function actionLogout () {
        Yii::$app->user->logout();
        return $this->redirect('login');
    }
}
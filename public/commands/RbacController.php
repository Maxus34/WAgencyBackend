<?php
/**
 * Created by PhpStorm.
 * User: MXS34
 * Date: 20.01.2018
 * Time: 16:53
 */

namespace app\commands;

use yii\console\Controller;

use app\models\User;
use app\rbac\UpdateOwnAccountRule;

class RbacController extends Controller
{

    /**
     * @return bool
     * @throws \yii\base\Exception
     * @throws \Exception
     */
    public function actionInit () {
        $authManager = \Yii::$app->authManager;

        $user    = $authManager -> createRole(User::ROLE_USER);
        $admin   = $authManager -> createRole(User::ROLE_ADMIN);


        $authManager->add($admin);
        $authManager->add($user);


        $authManager->addChild($admin, $user);


        // Assign roles to users
        $users = User::find()->all();

        /** @var User $user */
        foreach ($users as $user) {
            $roleToAssign = null;

            switch ($user->role) {
                case User::ROLE_ADMIN:
                    $roleToAssign = $admin;
                    break;
                default: $roleToAssign = $user;
            }

            $authManager->assign($roleToAssign, $user->id);
        }

        echo "success\n";

        return true;
    }
}
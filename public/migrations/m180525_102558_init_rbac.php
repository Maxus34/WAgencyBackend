<?php

use yii\db\Migration;

/**
 * Class m180525_102558_init_rbac
 */
class m180525_102558_init_rbac extends Migration
{
    public function safeUp()
    {
        Yii::$app->runAction('migrate/up', [
            'migrationPath' => '@yii/rbac/migrations',
            'interactive' => false, // таким образом мы всегда говорим yes на все запросы в консоли
        ]);


        $this->alterColumn('auth_assignment', 'user_id', $this->integer(11)->unsigned());
        $this->addForeignKey('fk-auth_assignment-user', 'auth_assignment', 'user_id', 'user', 'id');
    }


    public function safeDown()
    {
        return Yii::$app->runAction('migrate/down', [
            'migrationPath' => '@yii/rbac/migrations',
            'interactive' => false,
        ]);
    }
}

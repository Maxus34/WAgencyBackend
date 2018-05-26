<?php

use yii\db\Migration;
use yii\db\Expression;
use app\models\User;

/**
 * Class m180525_100143_add_user_table
 */
class m180525_100143_add_user_table extends Migration
{

    /**
     * @return bool|void
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id'       => $this->primaryKey()->unsigned(),
            'email'    => $this->string(255),

            'role'   => $this->string(64)->defaultValue(User::ROLE_USER),

            'passwordHash'       => $this->string(255)->notNull(),
            'passwordResetToken' => $this->string(255),
            'emailConfirmToken'  => $this->string(255),

            'createdAt'   => $this->dateTime()->defaultExpression('NOW()'),
            'updatedAt'   => $this->dateTime()->defaultExpression('NOW()'),
            'createdBy'   => $this->integer(11)->unsigned(),
            'updatedBy'   => $this->integer(11)->unsigned(),
        ]);

        $this->createBasicUserRecords();
    }


    public function safeDown()
    {
        $this->dropTable('user');
    }


    /**
     * @throws \yii\base\Exception
     */
    protected function createBasicUserRecords () {
        $this->batchInsert('user',
            ['id', 'email', 'role', 'passwordHash', 'createdAt', 'createdBy'],
            [
                ['1', 'admin@a.b',   User::ROLE_ADMIN,  Yii::$app->security->generatePasswordHash('admin'),   new Expression('NOW()'), '1'],
            ]
        );
    }
}

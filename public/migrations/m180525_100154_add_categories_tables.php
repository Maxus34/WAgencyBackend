<?php

use yii\db\Migration;

/**
 * Class m180525_100154_add_categories_tables
 */
class m180525_100154_add_categories_tables extends Migration
{

    public function safeUp()
    {
        $this->createTable('category', [
            'id'   => $this->primaryKey(11)->unsigned(),
            'name' => $this->string(255),

            'createdAt'   => $this->dateTime()->defaultExpression('NOW()'),
            'updatedAt'   => $this->dateTime()->defaultExpression('NOW()'),
            'createdBy'   => $this->integer(11)->unsigned(),
            'updatedBy'   => $this->integer(11)->unsigned(),
        ]);


        $this->createTable('childCategory', [
            'id'    => $this->primaryKey(11)->unsigned(),
            'catId' => $this->integer(11)->unsigned(),
            'name'  => $this->string(255),

            'createdAt'   => $this->dateTime()->defaultExpression('NOW()'),
            'updatedAt'   => $this->dateTime()->defaultExpression('NOW()'),
            'createdBy'   => $this->integer(11)->unsigned(),
            'updatedBy'   => $this->integer(11)->unsigned(),
        ]);


        $this->addForeignKey(
            'fk-category',
            'childCategory',
            'catId',
            'category',
            'id',
            'CASCADE', 'CASCADE'
        );
    }


    public function safeDown()
    {
        $this->dropForeignKey('fk-category', 'childCategory');
        $this->dropTable('childCategory');
        $this->dropTable('category');
    }
}

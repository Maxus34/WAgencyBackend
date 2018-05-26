<?php

use yii\db\Migration;
use app\models\records\ProductRecord;
/**
 * Class m180525_100202_add_product_table
 */
class m180525_100202_add_product_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(11)->unsigned(),
            'catId' => $this->integer(11)->unsigned(),

            'name' => $this->string(255),
            'price' => $this->float(),
            'type' => $this->integer()->defaultValue(ProductRecord::$TYPE_BUDGETARY),

            'createdAt'   => $this->dateTime()->defaultExpression('NOW()'),
            'updatedAt'   => $this->dateTime()->defaultExpression('NOW()'),
            'createdBy'   => $this->integer(11)->unsigned(),
            'updatedBy'   => $this->integer(11)->unsigned(),
        ]);

        $this->addForeignKey(
            'fk-product-cat',
            'product',
            'catId',
            'childCategory',
            'id',
            'CASCADE', 'CASCADE'
        );
    }


    public function safeDown()
    {
        $this->dropForeignKey('fk-product-cat', 'product');
        $this->dropTable('product');
    }

}

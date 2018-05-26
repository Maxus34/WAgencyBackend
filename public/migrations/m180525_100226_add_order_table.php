<?php

use yii\db\Migration;

/**
 * Class m180525_100226_add_order_table
 */
class m180525_100226_add_order_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('order', [
            'id'     => $this->primaryKey(11)->unsigned(),
            'qty'    => $this->integer(11),
            'sum'    => $this->float(),
            'status' => $this->boolean(),

            'name'  => $this->string(255),
            'email' => $this->string(255),
            'phone' => $this->string(100),

            'createdAt'   => $this->dateTime()->defaultExpression('NOW()'),
            'updatedAt'   => $this->dateTime()->defaultExpression('NOW()'),
            'createdBy'   => $this->integer(11)->unsigned(),
            'updatedBy'   => $this->integer(11)->unsigned(),
        ]);

        $this->createTable('orderItems', [
            'id'        => $this->primaryKey(11)->unsigned(),
            'orderId'   => $this->integer(11)->unsigned(),
            'productId' => $this->integer(11)->unsigned(),

            'qtyItems' => $this->integer(11),
            'sumItems' => $this->float(),

            'createdAt'   => $this->dateTime()->defaultExpression('NOW()'),
            'updatedAt'   => $this->dateTime()->defaultExpression('NOW()'),
            'createdBy'   => $this->integer(11)->unsigned(),
            'updatedBy'   => $this->integer(11)->unsigned(),
        ]);


        $this->addForeignKey(
            'fk_orderItems-order',
            'orderItems',
            'orderId',
            'order',
            'id',
            'CASCADE', 'CASCADE'
        );


        $this->addForeignKey(
            'fk_orderItems-product',
            'orderItems',
            'productId',
            'product',
            'id',
            'CASCADE', 'CASCADE'
        );
    }


    public function safeDown()
    {
        $this->dropForeignKey('fk_orderItems-order','orderItems');
        $this->dropForeignKey('fk_orderItems-product','orderItems');
        $this->dropTable('orderItems');
        $this->dropTable('order');
    }
}

<?php
namespace app\models\records;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;


/**
 * Class OrderItemRecord
 * @package app\models\records
 *
 * @property $id       integer
 * @property $orderId  integer
 * @property $productId integer
 * @property $qtyItems integer
 * @property $sumItems float
 */
class OrderItemRecord extends ActiveRecord
{
    public static function tableName () {
        return 'orderItems';
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_INSERT => 'createdAt',
                    ActiveRecord::EVENT_AFTER_UPDATE => 'updatedAt',
                ]
            ]
        ];
    }


    public function attributeLabels () {
        return [
            'id' => '№',
            'qtyItems' => 'Кол-во',
            'sumItems' => 'Сумма',
        ];
    }


    public function rules () {
        return [
            [['orderId', 'qtyItems', 'sumItems'], 'required'],
            [['orderId', 'qtyItems', 'sumItems'], 'number'],
        ];
    }


    public function getProduct () {
        return $this->hasOne(ProductRecord::class, ['id' => 'productId']);
    }
}
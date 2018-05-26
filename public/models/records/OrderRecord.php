<?php
namespace app\models\records;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;


/**
 * Class OrderRecord
 * @package app\models\records
 *
 * @property $id     integer
 * @property $qty    integer
 * @property $sum    float
 * @property $status boolean
 * @property $name   string
 * @property $email  string
 * @property $phone  string
 * @property $items  OrderItemRecord|array
 */
class OrderRecord extends ActiveRecord
{
    public static function tableName()
    {
        return 'order';
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
            'qty' => 'Кол-во',
            'sum' => 'Сумма',
            'status' => 'Статус',
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'createdAt' => 'Дата'
        ];
    }


    public function rules () {
        return [
            [['qty', 'sum', 'name', 'email', 'phone'], 'required'],
            [['qty', 'sum'], 'number'],
            [['status'], 'boolean'],
            [['name', 'email', 'phone'], 'string', 'max'=>100]
        ];
    }


    public function getItems () {
        return $this->hasMany(OrderItemRecord::class, ['orderId' => 'id']);
    }
}
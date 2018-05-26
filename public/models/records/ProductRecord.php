<?php
/**
 * Created by PhpStorm.
 * User: MXS34
 * Date: 25.05.2018
 * Time: 12:58
 */

namespace app\models\records;


use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\behaviors\ImageBehavior;

class ProductRecord extends ActiveRecord
{
    public static $TYPE_PREMIUM   = 1;
    public static $TYPE_COMMON    = 2;
    public static $TYPE_BUDGETARY = 3;


    public static function tableName()
    {
        return 'product';
    }


    public function rules () {
        return [
            [['catId', 'name', 'price', 'type'], 'required'],
            ['name', 'string', 'max' => 100],
        ];
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
            ],
            [
                'class'           => ImageBehavior::class,
                'placeholderPath' => 'images/placeholder/product_placeholder.png',
                'key'             => 'product',
            ]
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => '№',
            'category' => 'Категория',
            'name' => 'Название',
            'price' => 'Цена',
            'type' => 'Тип',
        ];
    }

    public function getTypeLabel () {
        $typeLabel = static::$TYPE_BUDGETARY;

        switch($this->type) {
            case static::$TYPE_BUDGETARY: return 'Бюджетный'; break;
            case static::$TYPE_COMMON: return 'Стандарт'; break;
            case static::$TYPE_PREMIUM: return 'Премиальный'; break;
        }
    }

    public function getCategory () {
        return $this->hasOne(ChildCategoryRecord::class, ['id' => 'catId']);
    }
}
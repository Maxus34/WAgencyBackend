<?php
/**
 * Created by PhpStorm.
 * User: MXS34
 * Date: 25.05.2018
 * Time: 12:58
 */

namespace app\models\records;

use yii\db\ActiveRecord;
use app\behaviors\ImageBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Class ChildCategoryRecord
 * @package app\models\records
 *
 * @property $id integer
 * @property $catId integer
 * @property $name string
 * @property $parent CategoryRecord
 */
class ChildCategoryRecord extends ActiveRecord
{
    public static function tableName()
    {
        return 'childCategory';
    }


    public function rules () {
        return [
            [['catId', 'name'], 'required']
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
                'placeholderPath' => 'images/placeholder/category_placeholder.png',
                'key'             => 'category[child]',
            ]
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => '№ категории',
            'parent' => 'Родительская категория',
            'name' => 'Название',
        ];
    }

    public function getParent () {
        return $this->hasOne(CategoryRecord::class, ['id' => 'catId']);
    }

    public function getProducts () {
        return $this->hasMany(ProductRecord::class, ['catId' => 'id']);
    }
}
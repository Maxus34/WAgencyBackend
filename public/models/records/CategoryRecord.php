<?php
namespace app\models\records;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\behaviors\ImageBehavior;

/**
 * Class CategoryRecord
 * @package app\models\records
 *
 * @property $id integer
 * @property $name string
 */
class CategoryRecord extends ActiveRecord
{
    public static function tableName() {
        return 'category';
    }


    public function extraFields()
    {
        return [
            'childs',
            'products',
        ];
    }


    public function rules () {
        return [
            [['name'], 'required'],
            ['name', 'string', 'max' => 100]
        ];
    }


    public function fields()
    {
        $fields = parent::fields();

        $fields['img'] = function () { return $_SERVER['HTTP_HOST'] . $this->getMainImage()->getUrl(); };

        return $fields;
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
                'key'             => 'category',
            ]
        ];
    }


    public function attributeLabels () {
        return [
            'id' => '№',
            'name' => 'Название',
            'createdAt' => 'Создано',
            'updatedAt' => 'Изменено',
        ];
    }


    public function getChilds () {
        return $this->hasMany(ChildCategoryRecord::class, ['catId' => 'id']);
    }


    public function getProducts () {
        return $this->hasMany(ProductRecord::class, ['catId', 'id'])
            ->via('childs');
    }
}
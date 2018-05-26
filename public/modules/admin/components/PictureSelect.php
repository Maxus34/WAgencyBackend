<?php
namespace app\modules\admin\components;

use yii\bootstrap\Widget;


class PictureSelect extends Widget
{
    public $model;
    public $attribute = null;

    public function run()
    {
        $main_image = $this->model->getMainImage();

        return $this->render("@app/modules/admin/components/tpl/select_picture.php",
            [
                'main_image' => $main_image,
                'attribute'  => $this->attribute,
            ]
        );
    }

}
<?php

use yii\db\Migration;

/**
 * Class m180525_100243_add_image_table
 */
class m180525_100243_add_image_table extends Migration
{

    public function safeUp()
    {
        $this->createTable("images", [
            'id'         => $this->primaryKey()->unsigned(),
            'itemId'     => $this->integer(11)->unsigned(),
            'fileId'     => $this->integer(11)->unsigned(),
            'isMain'     => $this->boolean(),
            'key'        => $this->string(),
            'createdAt'  => $this->integer(11)->unsigned(),
        ]);

        $this->addForeignKey(
            'fk-images-files_id',
            'images',
            'fileId',
            'files',
            'id',
            'CASCADE', 'CASCADE'
        ); // `images`.`file_id` => `files`.`id`
    }


    public function safeDown()
    {
        $this->dropForeignKey('fk-images-files_id', "images");
        $this->dropTable("images");
    }

}

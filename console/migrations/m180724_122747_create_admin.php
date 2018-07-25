<?php

use yii\db\Migration;

/**
 * Class m180724_122747_create_admin
 */
class m180724_122747_create_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user', [
            'username' => 'admin',
            'auth_key' => 'LhumqWLL5YxwdG6nuYl_NqYxDrX1ZH5S',
            'email' => 'admin@admin.com',
            'created_at' => time(),
            'updated_at' => time(),
            'password_hash' => '$2y$13$4JHSA4mxU1v.QBaP6/QqYO8.iGGK.zwhsu3JktCrSWm1Zr8YoHthS',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180724_122747_create_admin cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180724_122747_create_admin cannot be reverted.\n";

        return false;
    }
    */
}

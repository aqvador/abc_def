<?php

use yii\db\Migration;

/**
 * Class m220920_101000_create_table_abc_def
 */
class m220920_101000_create_table_abc_def extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('abc_def', [
            'id' => $this->primaryKey(),
            'code' => $this->integer()->notNull(),
            'interval_start' => $this->integer()->notNull(),
            'interval_end' => $this->integer()->notNull(),
            'capacity' => $this->integer()->notNull(),
            'opsos' => $this->string()->notNull(),
            'region' => $this->string()->notNull(),
            'city' => $this->string(),
            'district' => $this->string(),
            'village' => $this->string(),
            'inn' => $this->string()->notNull(),
            'gmt' => 'uuid not null'
        ]);

        $this->addForeignKey('key_abc_def_gmt', 'abc_def', 'gmt', 'abc_def_gmt', 'uuid');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('abc_def');
    }

}

<?php

use yii\db\Migration;

/**
 * Class m220930_112440_addColumnVersionToAbcDef
 */
class m220930_112440_addColumnVersionToAbcDef extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('abc_def','version',$this->integer()->notNull()->defaultValue(1)->comment('Версия обновления'));

        $this->createIndex('abc_def_version','abc_def','version');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('abc_def_version','abc_def');

        $this->dropColumn('abc_def', 'version');
    }

}

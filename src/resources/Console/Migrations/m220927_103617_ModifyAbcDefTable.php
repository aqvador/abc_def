<?php

use yii\db\Migration;

/**
 * Class m220927_103617_ModifyAbcDefTable
 */
class m220927_103617_ModifyAbcDefTable extends Migration
{
    private const TABLE = 'abc_def';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand('TRUNCATE TABLE abc_def')->execute();

        $this->dropColumn(self::TABLE, 'city');
        $this->dropColumn(self::TABLE, 'village');
        $this->dropColumn(self::TABLE, 'district');
        $this->dropColumn(self::TABLE, 'region');

        $this->addColumn(self::TABLE, 'region', 'jsonb not null');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->db->createCommand('TRUNCATE TABLE abc_def')->execute();

        $this->dropColumn(self::TABLE, 'region');

        $this->addColumn(self::TABLE, 'city', $this->string());
        $this->addColumn(self::TABLE, 'village', $this->string());
        $this->addColumn(self::TABLE, 'district', $this->string());
        $this->addColumn(self::TABLE, 'region', $this->string()->notNull());
    }
}

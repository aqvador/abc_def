<?php

use yii\db\Migration;

/**
 * Class m220929_164657_changeDataGmt
 */

use \Ramsey\Uuid\Uuid;

class m220929_164657_changeDataGmt extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $request = "UPDATE abc_def_gmt SET \"offset\" = REPLACE(\"offset\", 'UTC', 'GMT')";

        $this->db->createCommand($request)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $request = "UPDATE abc_def_gmt set \"offset\" = REPLACE(\"offset\", 'GMT', 'UTC')";

        $this->db->createCommand($request)->execute();
    }
}

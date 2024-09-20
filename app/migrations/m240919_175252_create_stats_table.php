<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stats}}`.
 */
class m240919_175252_create_stats_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stats}}', [
            'id' => $this->primaryKey(),
            'link_id' => $this->integer()->notNull(),
            'ip_address' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-stats-link-id',
            'stats',
            'link_id'
        );

        $this->addForeignKey(
            'fk-stats-link-id',
            'stats',
            'link_id',
            'link',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-stats-link-id',
            'stats'
        );

        $this->dropIndex(
            'idx-stats-link-id',
            'stats'
        );

        $this->dropTable('{{%stats}}');
    }
}

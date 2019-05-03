<?php

use yii\db\Migration;

/**
 * Class m190502_170023_create_client_address
 */
class m190502_170023_create_client_address extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client_address}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'city' => $this->string()->notNull(),
            'street' => $this->string()->notNull(),
            'number' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-client_address-client_id',
            'client_address',
            'client_id',
            'clients',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%client_address}}');
    }
}

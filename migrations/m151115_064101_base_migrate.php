<?php

use yii\db\Schema;
use yii\db\Migration;

class m151115_064101_base_migrate extends Migration
{
    /*
  public function up()
  {

  }

  public function down()
  {
      echo "m151115_064101_base_migrate cannot be reverted.\n";

      return false;
  }
    */

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'created_date' => $this->dateTime()->notNull(),
            'updated_date' => $this->dateTime()->notNull(),
            'username' => $this->string()->notNull(),
            'auth_key' => $this->string(32),
            'email_confirm_token' => $this->string(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'email' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('idx_user_username', '{{%user}}', 'username');
        $this->createIndex('idx_user_email', '{{%user}}', 'email');
        $this->createIndex('idx_user_status', '{{%user}}', 'status');

        $this->createTable('{{%currency}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'code' => $this->integer()->notNull(),
            'chCode' => $this->string()->notNull(),
            'sign' => $this->string()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(true),
        ], $tableOptions);

        $this->createTable('{{%currency_curs}}', [
            'id' => $this->primaryKey(),
            'currency_id' => $this->integer()->notNull(),
            'nom' => $this->integer()->notNull(),
            'curs' => $this->float()->notNull(),
            'rate' => $this->float()->notNull(),
            'date' => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_currency_curs_currency', 'currency_curs', 'currency_id', 'currency', 'id');

        $this->createTable('{{%budget}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'currency_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'created_date' => $this->dateTime()->notNull(),
            'updated_date' => $this->dateTime()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(true),
        ], $tableOptions);

        $this->addForeignKey('fk_budget_user', 'budget', 'user_id', 'user', 'id');
        $this->addForeignKey('fk_budget_currency', 'budget', 'currency_id', 'currency', 'id');

        $this->createTable('{{%type_budget_item}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string()->notNull(),
        ], $tableOptions);

        $this->insert('{{%type_budget_item}}', ['type'=>'Доход']);
        $this->insert('{{%type_budget_item}}', ['type'=>'Расход']);

        $this->createTable('{{%budget_item}}', [
            'id' => $this->primaryKey(),
            'patent_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'currency_id' => $this->integer()->notNull(),
            'type_budget_item_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'ammount' => $this->float()->notNull(),
            'date' => $this->dateTime()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(true),
        ], $tableOptions);

        $this->addForeignKey('fk_budget_item_currency', 'budget_item', 'currency_id', 'currency', 'id');
        $this->addForeignKey('fk_budget_item_patent', 'budget_item', 'patent_id', 'budget_item', 'id');
        $this->addForeignKey('fk_budget_item_user', 'budget_item', 'user_id', 'user', 'id');
        $this->addForeignKey('fk_budget_item_type_budget_item', 'budget_item', 'type_budget_item_id', 'type_budget_item', 'id');


        $this->createTable('{{%budget_history}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'budget_id' => $this->integer()->notNull(),
            'budget_item_id' => $this->integer()->notNull(),
            'ammount' => $this->float()->notNull(),
            'date' => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_budget_history_user', 'budget_history', 'user_id', 'user', 'id');
        $this->addForeignKey('fk_budget_history_budget', 'budget_history', 'budget_id', 'budget', 'id');
        $this->addForeignKey('fk_budget_history_budget_item', 'budget_history', 'budget_item_id', 'budget_item', 'id');

    }

    public function safeDown()
    {


        $this->dropIndex('idx_user_username', '{{%user}}');
        $this->dropIndex('idx_user_email', '{{%user}}');
        $this->dropIndex('idx_user_status', '{{%user}}');
        $this->dropForeignKey('fk_budget_user', '{{%budget}}');
        $this->dropForeignKey('fk_budget_currency', '{{%budget}}');
        $this->dropForeignKey('fk_currency_curs_currency', '{{%currency_curs}}');
        $this->dropForeignKey('fk_budget_item_currency', '{{%budget_item}}');
        $this->dropForeignKey('fk_budget_item_patent', '{{%budget_item}}');
        $this->dropForeignKey('fk_budget_item_user', '{{%budget_item}}');
        $this->dropForeignKey('fk_budget_item_type_budget_item', '{{%budget_item}}');
        $this->dropForeignKey('fk_budget_history_user', '{{%budget_history}}');
        $this->dropForeignKey('fk_budget_history_budget', '{{%budget_history}}');
        $this->dropForeignKey('fk_budget_history_budget_item', '{{%budget_history}}');


        $this->dropTable('{{%user}}');
        $this->dropTable('{{%currency}}');
        $this->dropTable('{{%currency_curs}}');
        $this->dropTable('{{%budget}}');
        $this->dropTable('{{%budget_item}}');
        $this->dropTable('{{%type_budget_item}}');
        $this->dropTable('{{%budget_history}}');


    }

}

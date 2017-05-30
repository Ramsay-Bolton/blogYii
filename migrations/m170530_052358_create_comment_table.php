<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m170530_052358_create_comment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'text' => $this->string(),
            'user_id' => $this->integer(),
            'article_id' => $this->integer(),
            'status' => $this->integer()
        ]);
        //создает индекс для колонки user_id
    $this->createIndex(
            'idx-post-user_id',
            'comment',
            'user_id'
            );
    //создает внешний ключ для таблицы user
    $this->addForeignKey(
            'fk-post-user_id',
            'comment',
            'user_id',
            'user',
            'id',
            'CASCADE'
            );
    //создает индекс для колонки user_id
    $this->createIndex(
            'idx-aricle_id',
            'comment',
            'article_id'
            );
    //создает внешний ключ для таблицы user
    $this->addForeignKey(
            'fk-article_id',
            'comment',
            'article_id',
            'article',
            'id',
            'CASCADE'
            );
    }
    
    

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('comment');
    }
}

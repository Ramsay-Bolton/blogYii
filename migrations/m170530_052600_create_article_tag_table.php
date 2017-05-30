<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_tag`.
 */
class m170530_052600_create_article_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_tag', [
            'id' => $this->primaryKey(),
            'article_id' =>$this->integer(),
            'tag_id' => $this->integer()
        ]);
        //создает индекс для колонки tag_id
    $this->createIndex(
            'idx-tag_id',
            'article_tag',
            'tag_id'
            );
    //создает внешний ключ для таблицы tag
    $this->addForeignKey(
            'fk-tag_id',
            'article_tag',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
            );
    //создает индекс для колонки tag_article_id
    $this->createIndex(
            'tag_article_article_id',
            'article_tag',
            'article_id'
            );
    //создает внешний ключ для таблицы user
    $this->addForeignKey(
            'tag_article_article_id',
            'article_tag',
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
        $this->dropTable('article_tag');
    }
}

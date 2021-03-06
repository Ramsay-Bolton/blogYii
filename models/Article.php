<?php

namespace app\models;

use Yii;
use app\models\ImageUpload;
use yii\db\ActiveQuery;
use app\models\ArticleTag;
use app\models\Tag;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $date
 * @property string $image
 * @property integer $viewed
 * @property integer $user_id
 * @property integer $status
 * @property integer $category_id
 */
class Article extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title'], 'required'],
            [['title', 'description', 'content'], 'string'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    public function saveImage($filename) {

        $this->image = $filename;

        return $this->save(false);
    }

    public function deleteImage() {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete() {
        $this->deleteImage();

        return parent::beforeDelete();
    }

    public function getImage() {
        return ($this->image) ? '/uploads/' . $this->image : '/no_image.png';
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function saveCategory($category_id) {
        $category = Category::findOne($category_id);

        if ($category != null) {
            $this->link('category', $category);
            return true;
        }
    }
    
    public function getTags() {
        return $this->hasMany(Tag::className(), ['id' =>'tag_id'])
                ->viaTable('article_tag', ['article_id' => 'id']);
    }
    
    public function getSelectedTags() {
        $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds, 'id');
        
    }
    
    public function saveTags($tags) {
            var_dump($tags);die;
        if(is_array($tags)) {
            ArticleTag::deleteAll(['article_id' => $this->id]);
            
            foreach ($tags as $tag_id) {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

}

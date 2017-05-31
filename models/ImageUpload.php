<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\base\Model;

class ImageUpload extends Model {

    public $image;  //создание атрибута image

    public function uploadImage($file, $currentImage) {  //метод, реализующий загрузку изображения в базу
        $this->image = $file;  //присваиваем фйл в качестве атрибуты

        if ($this->validate()) {

            $this->deleteCurrentImage($currentImage);

            return $this->saveImage();
        }
    }

    private function getFolder() {
        return Yii::getAlias('@web') . 'uploads/';
    }

    private function generateFilename() {
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }

    public function deleteCurrentImage($currentImage) {
        if ($this->fileExists($currentImage)) {
            unlink($this->getFolder() . $currentImage);
        }
    }

    public function fileExists($currentImage) {
        if (!empty($currentImage) && $currentImage != null) {
            return file_exists($this->getFolder() . $currentImage);
        }
    }

    public function saveImage() {
        $filename = $this->generateFilename();

        $this->image->saveAs($this->getFolder() . $filename);

        return $filename;
    }

}

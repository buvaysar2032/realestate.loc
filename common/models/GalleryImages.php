<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "gallery_images".
 *
 * @property int $id
 * @property int $gallery_id
 * @property string $image
 * @property string|null $title
 * @property string|null $text
 *
 * @property Galleries $gallery
 */
class GalleryImages extends \yii\db\ActiveRecord
{
    public UploadedFile|string|null $imageFile = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gallery_id'], 'required'],
            [['gallery_id'], 'integer'],
            [['text'], 'string'],
            [['image', 'title'], 'string', 'max' => 255],
            [['gallery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Galleries::class, 'targetAttribute' => ['gallery_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'gallery_id' => Yii::t('app', 'Gallery ID'),
            'image' => Yii::t('app', 'Image'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
        ];
    }

    /**
     * Gets query for [[Gallery]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGallery()
    {
        return $this->hasOne(Galleries::class, ['id' => 'gallery_id']);
    }

    public function beforeValidate(): bool // Валидация
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        return parent::beforeValidate();
    }

    public function beforeSave($insert): bool // Загрузка
    {
        if ($this->imageFile) {
            if (!empty($this->image)) {
                $imagePath = Yii::getAlias('@public/') . $this->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $randomString = Yii::$app->security->generateRandomString();
            $fileName = $this->imageFile->extension;
            $path = Yii::getAlias('@uploads') . '/' . $randomString . '.' . $fileName;

            if ($this->imageFile->saveAs($path)) {
                $this->image = 'uploads/' . $randomString . '.' . $fileName;
            }
        }
        return parent::beforeSave($insert);
    }
}

<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "apartments".
 *
 * @property int $id
 * @property string $title
 * @property string|null $subtitle
 * @property string|null $description
 * @property int $price
 * @property int $floor
 * @property string|null $image
 * @property string|null $address
 * @property string|null $additional_title
 * @property string|null $svg_image
 * @property int $available
 *
 * @property Rooms[] $rooms
 */
class Apartments extends \yii\db\ActiveRecord
{
    public UploadedFile|string|null $imageFile = null;
    public UploadedFile|string|null $imageFile2 = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apartments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'price', 'floor'], 'required'],
            [['description'], 'string'],
            [['price', 'floor', 'available'], 'integer'],
            [['title', 'subtitle', 'image', 'address', 'additional_title', 'svg_image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'subtitle' => Yii::t('app', 'Subtitle'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'floor' => Yii::t('app', 'Floor'),
            'image' => Yii::t('app', 'Image'),
            'address' => Yii::t('app', 'Address'),
            'additional_title' => Yii::t('app', 'Additional Title'),
            'svg_image' => Yii::t('app', 'Svg Image'),
            'available' => Yii::t('app', 'Available'),
        ];
    }

    /**
     * Gets query for [[Rooms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasMany(Rooms::class, ['apartment_id' => 'id']);
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'subtitle',
            'description',
            'price',
            'floor',
            'image',
            'address',
            'additional_title',
            'rooms',
            'svg_image',
            //'available'
        ];
    }

    public function beforeValidate(): bool // Валидация
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        $this->imageFile2 = UploadedFile::getInstance($this, 'imageFile2');
        return parent::beforeValidate();
    }

    public function beforeSave($insert): bool
    {
        $this->deleteImage($this->image);
        $this->deleteImage($this->svg_image);

        if ($this->imageFile) {
            $this->image = $this->saveImage($this->imageFile);
        }

        if ($this->imageFile2) {
            $this->svg_image = $this->saveImage($this->imageFile2);
        }

        return parent::beforeSave($insert);
    }

    public function deleteImage($imagePath)
    {
        if (!empty($imagePath)) {
            $fullPath = Yii::getAlias('@public/') . $imagePath;
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }

    public function saveImage(UploadedFile $file)
    {
        $randomString = Yii::$app->security->generateRandomString();
        $fileName = $file->extension;
        $path = Yii::getAlias('@uploads') . '/' . $randomString . '.' . $fileName;

        if ($file->saveAs($path)) {
            return 'uploads/' . $randomString . '.' . $fileName;
        }

        return null;
    }
}
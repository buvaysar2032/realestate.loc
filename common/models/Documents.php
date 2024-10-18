<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "documents".
 *
 * @property int $id
 * @property string $key
 * @property string $file
 */
class Documents extends \yii\db\ActiveRecord
{
    public UploadedFile|string|null $documentFile = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['key', 'file'], 'string', 'max' => 255],
            ['documentFile', 'file']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'key' => Yii::t('app', 'Key'),
            'file' => Yii::t('app', 'File'),
        ];
    }

    public function beforeValidate(): bool // Валидация
    {
        $this->documentFile = UploadedFile::getInstance($this, 'documentFile');
        return parent::beforeValidate();
    }

    public function beforeSave($insert): bool // Загрузка
    {
        if ($this->documentFile) {
            $this->deleteFile($this->file);

            $randomString = Yii::$app->security->generateRandomString();
            $fileName = $this->documentFile->extension;
            $path = Yii::getAlias('@uploads') . '/' . $randomString . '.' . $fileName;

            if ($this->documentFile->saveAs($path)) {
                $this->file = 'uploads/' . $randomString . '.' . $fileName;
            }
        }
        return parent::beforeSave($insert);
    }

    public function deleteFile($filePath)
    {
        if (!empty($filePath)) {
            $fullPath = Yii::getAlias('@public/') . $filePath;
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}

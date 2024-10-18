<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "texts".
 *
 * @property int $id
 * @property string $key
 * @property string|null $group
 * @property string $text
 * @property string|null $comment
 * @property int|null $deletable
 */
class Texts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'texts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'text'], 'required'],
            [['text'], 'string'],
            [['deletable'], 'integer'],
            [['key', 'group', 'comment'], 'string', 'max' => 255],
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
            'group' => Yii::t('app', 'Group'),
            'text' => Yii::t('app', 'Text'),
            'comment' => Yii::t('app', 'Comment'),
            'deletable' => Yii::t('app', 'Deletable'),
        ];
    }
}

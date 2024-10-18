<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rooms".
 *
 * @property int $id
 * @property int $apartment_id
 * @property string $name
 * @property int|null $area
 * @property string|null $uid
 *
 * @property Apartments $apartment
 */
class Rooms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rooms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['apartment_id', 'area'], 'integer'],
            [['name', 'uid'], 'string', 'max' => 255],
            [['apartment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Apartments::class, 'targetAttribute' => ['apartment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'apartment_id' => Yii::t('app', 'Apartment ID'),
            'name' => Yii::t('app', 'Name'),
            'area' => Yii::t('app', 'Area'),
            'uid' => Yii::t('app', 'Uid'),
        ];
    }

    public function fields()
    {
        return [
            'name',
            'area',
            'uid'
        ];
    }

    /**
     * Gets query for [[Apartment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApartment()
    {
        return $this->hasOne(Apartments::class, ['id' => 'apartment_id']);
    }
}

<?php

use yii\db\Migration;

/**
 * Class m241017_065322_create_main_tables
 */
class m241017_065322_create_main_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Создание таблицы Квартиры
        $this->createTable('{{%apartments}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'subtitle' => $this->string(),
            'description' => $this->text(),
            'price' => $this->integer()->notNull(),
            'floor' => $this->integer()->notNull(),
            'image' => $this->string(),
            'address' => $this->string(),
            'additional_title' => $this->string(),
            'svg_image' => $this->string(),
            'available' => $this->boolean()->defaultValue(false)->notNull(),
        ]);

        // Создание таблицы Комнаты
        $this->createTable('{{%rooms}}', [
            'id' => $this->primaryKey(),
            'apartment_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'area' => $this->integer(),
            'uid' => $this->string(),
        ]);

        // Связь Комнаты с Квартирами
        $this->addForeignKey(
            'fk_rooms_apartment',
            '{{%rooms}}',
            'apartment_id',
            '{{%apartments}}',
            'id',
            'CASCADE'
        );

        // Создание таблицы Тексты
        $this->createTable('{{%texts}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string()->notNull(),
            'group' => $this->string(),
            'text' => $this->text()->notNull(),
            'comment' => $this->string(),
            'deletable' => $this->boolean()->defaultValue(true),
        ]);

        // Создание неудаляемых текстов для группы contacts
        $this->batchInsert('{{%texts}}', ['key', 'group', 'text', 'comment', 'deletable'], [
            ['main_address', 'contacts', 'Основной адрес', 'Описание основного адреса', false],
            ['main_phone', 'contacts', 'Основной телефон', 'Описание основного телефона', false],
            ['sales_office_address', 'contacts', 'Офис продаж. Адрес', 'Описание адреса офиса продаж', false],
            ['sales_office_phone', 'contacts', 'Офис продаж. Телефон', 'Описание телефона офиса продаж', false],
        ]);

        // Создание таблицы Документы
        $this->createTable('{{%documents}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string()->notNull(),
            'file' => $this->string()->notNull(),
        ]);

        // Создание таблицы Галереи
        $this->createTable('{{%galleries}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
        ]);

        // Создание таблицы Изображения галерей
        $this->createTable('{{%gallery_images}}', [
            'id' => $this->primaryKey(),
            'gallery_id' => $this->integer()->notNull(),
            'image' => $this->string()->notNull(),
            'title' => $this->string(),
            'text' => $this->text(),
        ]);

        // Связь Изображения галерей с Галереями
        $this->addForeignKey(
            'fk_gallery_images_gallery',
            '{{%gallery_images}}',
            'gallery_id',
            '{{%galleries}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_gallery_images_gallery', '{{%gallery_images}}');
        $this->dropTable('{{%gallery_images}}');
        $this->dropTable('{{%galleries}}');

        $this->dropTable('{{%documents}}');

        $this->delete('{{%texts}}', ['group' => 'contacts']);
        $this->dropTable('{{%texts}}');

        $this->dropForeignKey('fk_rooms_apartment', '{{%rooms}}');
        $this->dropTable('{{%rooms}}');
        $this->dropTable('{{%apartments}}');
    }
}
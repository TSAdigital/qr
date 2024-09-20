<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "link".
 *
 * @property int $id
 * @property string $link
 * @property string $short_link
 * @property int $created_at
 * @property int $updated_at
 */
class Link extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['link', 'url'],
            ['link', 'string', 'max' => 255],
            ['link', 'required'],

            ['short_link', 'string', 'max' => 255],
            ['short_link', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'link' => 'Адрес сайта',
            'short_link' => 'Короткая ссылка',
            'qr_code' => 'QR код',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
        ];
    }
}

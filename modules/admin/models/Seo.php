<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "seo".
 *
 * @property integer $id
 * @property string $url
 * @property string $rus_url
 * @property string $title
 * @property string $meta
 * @property string $title_text
 * @property string $html_1_header
 * @property string $html_1_text
 * @property string $html_2_header
 * @property string $html_2_text
 */
class Seo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'title', 'meta', 'title_text'], 'required'],
            [['title', 'meta', 'title_text', 'html_1_text', 'html_2_text'], 'string'],
            [['url', 'rus_url', 'html_1_header', 'html_2_header'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['rus_url'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'rus_url' => 'Rus Url',
            'title' => 'Title',
            'meta' => 'Meta',
            'title_text' => 'Title Text',
            'html_1_header' => 'Заголовок 1 блока',
            'html_1_text' => 'Текст 1 блока',
            'html_2_header' => 'Заголовок 2 блока',
            'html_2_text' => 'Текст 2 блока',
        ];
    }

    /**
     * @inheritdoc
     * @return SeoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeoQuery(get_called_class());
    }
}

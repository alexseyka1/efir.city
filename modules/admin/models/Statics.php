<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "static".
 *
 * @property integer $id
 * @property string $page_name
 * @property string $content
 */
class Statics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'static';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_name', 'content'], 'required'],
            [['content'], 'string'],
            [['page_name'], 'string', 'max' => 255],
            [['page_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_name' => 'Page Name',
            'content' => 'Content',
        ];
    }

    /**
     * @inheritdoc
     * @return StaticQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaticQuery(get_called_class());
    }
}

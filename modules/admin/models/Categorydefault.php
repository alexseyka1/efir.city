<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "category_default".
 *
 * @property integer $id
 * @property string $category_name
 * @property integer $sort
 * @property string $icon
 * @property integer $active
 */
class Categorydefault extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_default';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'sort'], 'required'],
            [['sort', 'active'], 'integer'],
            [['category_name', 'icon'], 'string', 'max' => 255],
            [['category_name'], 'unique'],
            [['sort'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'sort' => 'Sort',
            'icon' => 'Icon',
            'active' => 'Active',
        ];
    }

    /**
     * @inheritdoc
     * @return CategorydefaultQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategorydefaultQuery(get_called_class());
    }
}

<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $category_name
 * @property integer $city_id
 * @property integer $city_number
 * @property integer $sort
 * @property string $icon
 * @property integer $active
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'city_id', 'city_number', 'sort'], 'required'],
            [['city_id', 'city_number', 'sort', 'active'], 'integer'],
            [['category_name', 'icon'], 'string', 'max' => 255],
            [['city_id', 'city_number'], 'unique', 'targetAttribute' => ['city_id', 'city_number'], 'message' => 'The combination of City ID and City Number has already been taken.'],
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
            'city_id' => 'City ID',
            'city_number' => 'City Number',
            'sort' => 'Sort',
            'icon' => 'Icon',
            'active' => 'Active',
        ];
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}

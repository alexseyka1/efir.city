<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property integer $country_id
 * @property integer $city_id
 * @property string $country_name
 * @property string $code_iso
 * @property integer $phone_code
 * @property integer $active
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'phone_code', 'active'], 'integer'],
            [['country_name'], 'string', 'max' => 128],
            [['code_iso'], 'string', 'max' => 255],
            [['code_iso', 'phone_code'], 'unique', 'targetAttribute' => ['code_iso', 'phone_code'], 'message' => 'The combination of Code Iso and Phone Code has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_id' => 'Country ID',
            'city_id' => 'City ID',
            'country_name' => 'Country Name',
            'code_iso' => 'Code Iso',
            'phone_code' => 'Phone Code',
            'active' => 'Active',
        ];
    }

    /**
     * @inheritdoc
     * @return CountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountryQuery(get_called_class());
    }
}

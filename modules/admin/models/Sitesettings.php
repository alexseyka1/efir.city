<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "site_settings".
 *
 * @property integer $id
 * @property string $settings_key
 * @property string $value
 */
class Sitesettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['settings_key', 'value'], 'required'],
            [['value'], 'string'],
            [['settings_key'], 'string', 'max' => 255],
            [['settings_key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'settings_key' => 'Settings Key',
            'value' => 'Value',
        ];
    }

    /**
     * @inheritdoc
     * @return SitesettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SitesettingsQuery(get_called_class());
    }
}

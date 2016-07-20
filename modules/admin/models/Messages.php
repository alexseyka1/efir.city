<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property integer $id
 * @property string $post_datetime
 * @property string $author_name
 * @property string $author_uid
 * @property string $message_text
 * @property integer $city_id
 * @property integer $category_id
 * @property string $pay_phone
 * @property string $connect_phone
 * @property integer $is_paid
 * @property integer $is_published
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_datetime', 'author_name', 'author_uid', 'message_text', 'city_id', 'category_id', 'pay_phone', 'connect_phone'], 'required'],
            [['post_datetime'], 'safe'],
            [['message_text'], 'string'],
            [['city_id', 'category_id', 'is_paid', 'is_published'], 'integer'],
            [['author_name', 'author_uid', 'pay_phone', 'connect_phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_datetime' => 'Post Datetime',
            'author_name' => 'Author Name',
            'author_uid' => 'Author Uid',
            'message_text' => 'Message Text',
            'city_id' => 'City ID',
            'category_id' => 'Category ID',
            'pay_phone' => 'Pay Phone',
            'connect_phone' => 'Connect Phone',
            'is_paid' => 'Is Paid',
            'is_published' => 'Is Published',
        ];
    }

    /**
     * @inheritdoc
     * @return MessagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MessagesQuery(get_called_class());
    }
}

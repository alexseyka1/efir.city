<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Messages;

/**
 * MessagesSearch represents the model behind the search form about `app\modules\admin\models\Messages`.
 */
class MessagesSearch extends Messages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'city_id', 'category_id', 'is_paid', 'is_published', 'is_sent_sms'], 'integer'],
            [['post_datetime', 'author_name', 'author_uid', 'message_to', 'message_text', 'pay_phone', 'connect_phone'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Messages::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'post_datetime' => $this->post_datetime,
            'city_id' => $this->city_id,
            'category_id' => $this->category_id,
            'is_paid' => $this->is_paid,
            'is_published' => $this->is_published,
            'is_sent_sms' => $this->is_sent_sms,
        ]);

        $query->andFilterWhere(['like', 'author_name', $this->author_name])
            ->andFilterWhere(['like', 'author_uid', $this->author_uid])
            ->andFilterWhere(['like', 'message_to', $this->message_to])
            ->andFilterWhere(['like', 'message_text', $this->message_text])
            ->andFilterWhere(['like', 'pay_phone', $this->pay_phone])
            ->andFilterWhere(['like', 'connect_phone', $this->connect_phone]);

        return $dataProvider;
    }
}

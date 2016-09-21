<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Seo;

/**
 * SeoSearch represents the model behind the search form about `app\modules\admin\models\Seo`.
 */
class SeoSearch extends Seo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['url', 'rus_url', 'title', 'meta', 'title_text', 'html_1_header', 'html_1_text', 'html_2_header', 'html_2_text'], 'safe'],
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
        $query = Seo::find();

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
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'rus_url', $this->rus_url])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'meta', $this->meta])
            ->andFilterWhere(['like', 'title_text', $this->title_text])
            ->andFilterWhere(['like', 'html_1_header', $this->html_1_header])
            ->andFilterWhere(['like', 'html_1_text', $this->html_1_text])
            ->andFilterWhere(['like', 'html_2_header', $this->html_2_header])
            ->andFilterWhere(['like', 'html_2_text', $this->html_2_text]);

        return $dataProvider;
    }
}

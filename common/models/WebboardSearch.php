<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Webboard;

/**
 * WebboardSearch represents the model behind the search form about `common\models\Webboard`.
 */
class WebboardSearch extends Webboard
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['QuestionID', 'View', 'Reply'], 'integer'],
            [['CreateDate', 'Question', 'Details', 'Name'], 'safe'],
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
        $query = Webboard::find();

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
            'QuestionID' => $this->QuestionID,
            'CreateDate' => $this->CreateDate,
            'View' => $this->View,
            'Reply' => $this->Reply,
        ]);

        $query->andFilterWhere(['like', 'Question', $this->Question])
            ->andFilterWhere(['like', 'Details', $this->Details])
            ->andFilterWhere(['like', 'Name', $this->Name]);

        return $dataProvider;
    }
}

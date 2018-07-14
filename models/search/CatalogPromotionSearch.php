<?php

namespace modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modules\catalog\models\CatalogPromotion;
use yii\helpers\VarDumper;

/**
 * CatalogPromotionSearch represents the model behind the search form of `modules\catalog\models\CatalogPromotion`.
 */
class CatalogPromotionSearch extends CatalogPromotion
{
    public $date_from_start;
    public $date_from_end;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'discount', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description', 'date_from_start', 'date_from_end'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param $params
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        $query = CatalogPromotion::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'discount' => $this->discount,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['>=', 'start_at', $this->date_from_start ? strtotime($this->date_from_start . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'start_at', $this->date_from_start ? strtotime($this->date_from_start . ' 23:59:59') : null])
            ->andFilterWhere(['>=', 'end_at', $this->date_from_end ? strtotime($this->date_from_end . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'end_at', $this->date_from_end ? strtotime($this->date_from_end . ' 23:59:59') : null]);

        return $dataProvider;
    }
}

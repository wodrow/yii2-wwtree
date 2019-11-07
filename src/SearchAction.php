<?php
/**
 * Created by PhpStorm.
 * User: Wodro
 * Date: 2019/11/7
 * Time: 9:30
 */

namespace wodrow\yii2wwtree;


use wodrow\yii2wtools\tools\ArrayHelper;
use yii\base\Action;
use yii\db\ActiveQuery;
use yii\web\JsExpression;
use yii\web\Response;

class SearchAction extends Action
{
    public $searchClass;
    public $idKeyAttr = 'id';
    public $textKeyAttr = 'text';

    public static function getSelect2Config($node, $primaryKey, $parnetKey, $nameKey, $ajaxUrl)
    {
        if ($ajaxUrl){
            if ($node->$parnetKey){
                $initValueText = $node->parent->$nameKey;
            }else{
                $initValueText = null;
            }
            $select2Config = [
                'initValueText' => $initValueText,
                'options' => [],
                'pluginOptions' => [
                    'placeholder' => '请输入名称搜索',
                    'allowClear' => true,
                    'ajax' => [
                        'url' => $ajaxUrl,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {search:params.term}; }'),
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(res) { return res.text; }'),
                        'templateSelection' => new JsExpression('function (res) { return res.text; }'),
                    ],
                ]
            ];
        }else{
            $select2Config = [
                'data' => ArrayHelper::map($node::find()->select([$primaryKey, $nameKey])->all(), $primaryKey, $nameKey),
            ];
        }
        return $select2Config;
    }

    public function run()
    {
        $searchClass = $this->searchClass;
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = [];
        $search = null;
        if (\Yii::$app->request->get('search')){
            $search = \Yii::$app->request->get('search');
        }
        /**
         * @var ActiveQuery $query
         */
        $query = $searchClass::find();
        $query = $query->select(['id' => $this->idKeyAttr, 'text' => $this->textKeyAttr]);
        if ($search) {
            $query->andFilterWhere(['like', $this->textKeyAttr, $search]);
        }
        $data = $query->limit(10)
            ->asArray()
            ->all();

        $out['results'] = array_values($data);

        return $out;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-1-18
 * Time: 下午8:12
 */

namespace wodrow\yii2wwtree;


use yii\helpers\Url;
use yii\base\Model;

class FormTransNode extends Model
{
    public $modelClass;
    public $slid;
    public $tnid;

    public function rules()
    {
        return [
            ['modelClass', 'required'],
            ['modelClass', 'safe'],
            ['slid', 'required'],
            ['slid', 'number'],
            ['tnid', 'required'],
            ['tnid', 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'modelClass' => \Yii::t('app', "模型类名"),
            'slid' => \Yii::t('app', "选择的节点"),
            'tnid' => \Yii::t('app', "互相交换的节点"),
        ];
    }

    public function doTrans()
    {
        $class = $this->modelClass;
        $sl = $class::find()->where(['id' => $this->slid])->one();
        $tn = $class::find()->where(['id' => $this->tnid])->one();
        \common\members\wodrow\tools\Model::switchPlaceModelValue($sl, $tn, ['id', 'pid', 'sort']);
        \Yii::$app->session->addFlash("success", \Yii::t('app', "交换位置成功"));
        $url = Url::to(['/'.\Yii::$app->controller->route, 'id' => $tn->id]);
        \Yii::$app->response->redirect($url)->send();
        exit;
    }
}
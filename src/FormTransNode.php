<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-1-18
 * Time: 下午8:12
 */

namespace wodrow\yii2wwtree;


use yii\db\ActiveRecord;
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

    public function doTrans($primaryKey, $parentKey, $sortKey)
    {
        $class = $this->modelClass;
        /**
         * @var ActiveRecord $sl
         * @var ActiveRecord $tn
         */
        $sl = $class::findOne([$primaryKey => $this->slid]);
        $tn = $class::findOne([$primaryKey => $this->tnid]);
        if (TreeTools::switchNodes($sl, $tn, $primaryKey, $parentKey, $sortKey)){
            \Yii::$app->session->addFlash("success", \Yii::t('app', "交换位置成功"));
        }else{
            \Yii::$app->session->addFlash("error", \Yii::t('app', "交换位置失败"));
        }
        $url = Url::to(['/'.\Yii::$app->controller->route, 'id' => $tn->$primaryKey]);
        \Yii::$app->response->redirect($url)->send();
        exit;
    }
}
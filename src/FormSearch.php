<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-1-21
 * Time: 上午11:08
 */

namespace wodrow\yii2wwtree;

use yii\base\Model;

class FormSearch extends Model
{
    public $key;

    public function rules()
    {
        return [
            ['key', 'trim'],
            ['key', 'required'],
            ['key', 'string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'key' => \Yii::t('app', "关键字"),
        ];
    }
}
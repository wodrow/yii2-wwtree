<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-1-17
 * Time: 下午1:33
 */

namespace wodrow\yii2wwtree;


use yii\web\AssetBundle;

class TreeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/wodrow/yii2wwtree/static';

    public function init()
    {
        $this->css = [
            'ww-tree.css',
        ];
    }
}
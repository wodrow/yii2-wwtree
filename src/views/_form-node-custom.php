<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-1-21
 * Time: 下午4:29
 */
/**
 * @var \yii\web\View $this
 * @var \yii\db\ActiveRecord|\wodrow\yii2wwtree\TreeBehavior $node
 */

$primaryKey = $node->primaryKeyAttribute;
$parentKey = $node->parentKeyAttribute;
$nameKey = $node->nameKeyAttribute;
$iconKey = $node->iconKeyAttribute;
$iconColorKey = $node->iconColorKeyAttribute;
$sortKey = $node->sortKeyAttribute;
?>

<?= \Yii::t('app', "请配置你自己的扩展字段视图位置") ?>

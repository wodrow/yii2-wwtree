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

<p>
    当前扩展视图位置在
</p>
<p>
    <code><?=__FILE__ ?></code>,
</p>
<p>
    <?= \Yii::t('app', "你可以在custom_field_view配置扩展字段视图位置") ?>
</p>

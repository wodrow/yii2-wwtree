<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-1-17
 * Time: 下午3:24
 */
/**
 * @var \yii\web\View $this
 * @var array $tree
 * @var \yii\db\ActiveRecord|\wodrow\yii2wwtree\TreeBehavior $node
 */
use yii\helpers\Html;
use kartik\icons\Icon;

$primaryKey = $node->primaryKeyAttribute;
$parentKey = $node->parentKeyAttribute;
$nameKey = $node->nameKeyAttribute;
$iconKey = $node->iconKeyAttribute;
$iconColorKey = $node->iconColorKeyAttribute;
$sortKey = $node->sortKeyAttribute;
?>

<ul>
    <?php foreach ($tree as $k => $v): ?>
        <?php
            $ns = '';
            foreach ($v['_styles'] as $k1 => $v1){
                if ($v1 == 0)$ns .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                if ($v1 == 1)$ns .= "|&nbsp;&nbsp;&nbsp;&nbsp;";
                if ($v1 == 2)$ns .= "|_&nbsp";
            }
            $active = 0;
            if ($v[$primaryKey] == Yii::$app->request->get('id')){
                $active = 1;
            }
            $add_for = 0;
            if ($v[$primaryKey] == Yii::$app->request->get('add-for')){
                $add_for = 1;
            }
        ?>
        <?=Html::a(Html::tag('li', Html::tag('span', $ns, ['class' => "ww-ns"]).Icon::show($v[$iconKey], ['style' => ['color' => $v[$iconColorKey]]]).$v[$nameKey], ['class' => ($active?"active ":" ").($add_for?"ww-add-for":"")]), ["/".Yii::$app->controller->route, 'id'=>$v[$primaryKey]]) ?>
        <?php if (isset($v['_child'])): ?>
            <?=$this->render('tree-view', ['tree' => $v['_child'], 'node' => $node]) ?>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
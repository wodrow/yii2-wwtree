<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-1-18
 * Time: 上午11:05
 */
/**
 * @var \yii\web\View $this
 * @var array $tree
 * @var \yii\base\Model $node
 */
use yii\helpers\Html;
use kartik\icons\Icon;
?>

<div class="btn-group-sm btn-group" role="group">
    <?=Html::a(Icon::show('plus'), ['/'.Yii::$app->controller->route, 'add-for' => $node->id], ['class' => "btn btn-default", 'title' => \Yii::t('app', "添加节点"), 'disabled' => $node->canAddChild?false:true]) ?>
    <?=Html::a(Icon::show('tree'), ['/'.Yii::$app->controller->route], ['class' => "btn btn-default", 'title' => \Yii::t('app', "添加根节点")]) ?>
    <?=Html::a(Icon::show('trash'), ['/'.Yii::$app->controller->route, 'delete-for' => $node->id], ['class' => "btn btn-default", 'title' => \Yii::t('app', "删除"), 'disabled' => $node->canDelete?false:true, 'data-confirm' => \Yii::t('app', "确认删除?你将删除所有子节点!")]) ?>
</div>
<div class="btn-group-sm btn-group" role="group">
    <?=Html::a(Icon::show('arrow-up'), ['/'.Yii::$app->controller->route, 'id' => $node->id, 'sort_action' => 'up'], ['class' => "btn btn-default", 'title' => \Yii::t('app', "上移"), 'disabled' => $node->canUp?false:true]) ?>
    <?=Html::a(Icon::show('arrow-down'), ['/'.Yii::$app->controller->route, 'id' => $node->id, 'sort_action' => 'down'], ['class' => "btn btn-default", 'title' => \Yii::t('app', "下移"), 'disabled' => $node->canDown?false:true]) ?>
    <?=Html::a(Icon::show('arrow-left'), ['/'.Yii::$app->controller->route, 'id' => $node->id, 'sort_action' => 'left'], ['class' => "btn btn-default", 'title' => \Yii::t('app', "左移"), 'disabled' => $node->canLeft?false:true]) ?>
    <?=Html::a(Icon::show('arrow-right'), ['/'.Yii::$app->controller->route, 'id' => $node->id, 'sort_action' => 'right'], ['class' => "btn btn-default", 'title' => \Yii::t('app', "右移"), 'disabled' => $node->canRight?false:true]) ?>
</div>
<div class="btn-group-sm btn-group" role="group">
    <?php // echo Html::a(Icon::show('refresh', ['style' => []]), Yii::$app->request->absoluteUrl, ['class' => "btn btn-default", 'title' => \Yii::t('app', "刷新")]) ?>
</div>

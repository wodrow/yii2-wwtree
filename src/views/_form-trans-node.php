<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-1-18
 * Time: 下午8:22
 */
/**
 * @var \yii\web\View $this
 * @var array $tree
 * @var \yii\db\ActiveRecord|\wodrow\yii2wwtree\TreeBehavior $node
 * @var string $ajaxUrl
 * @var FormTransNode $trans_node_form
 */
use kartik\form\ActiveForm;
use yii\helpers\Html;
use wodrow\yii2wwtree\FormTransNode;
use kartik\select2\Select2;

$primaryKey = $node->primaryKeyAttribute;
$parentKey = $node->parentKeyAttribute;
$nameKey = $node->nameKeyAttribute;
$iconKey = $node->iconKeyAttribute;
$iconColorKey = $node->iconColorKeyAttribute;
$sortKey = $node->sortKeyAttribute;
$select2Config = \wodrow\yii2wwtree\SearchAction::getSelect2Config($node, $primaryKey, $parentKey, $nameKey, $ajaxUrl);
?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-sm-6">
        <?=$form->field($trans_node_form, 'tnid')->widget(Select2::class, $select2Config)->label(false) ?>
    </div>
    <div class="col-sm-6">
        <?=Html::submitButton(\Yii::t('app', "交换节点位置"), ['class' => "btn btn-primary"]) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
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
 * @var FormTransNode $trans_node_form
 */
use kartik\form\ActiveForm;
use yii\helpers\Html;
use wodrow\yii2wwtree\FormTransNode;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$primaryKey = $node->primaryKeyAttribute;
$parentKey = $node->parentKeyAttribute;
$nameKey = $node->nameKeyAttribute;
$iconKey = $node->iconKeyAttribute;
$iconColorKey = $node->iconColorKeyAttribute;
$sortKey = $node->sortKeyAttribute;
?>

<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_INLINE]); ?>
<?=$form->field($trans_node_form, 'tnid')->widget(Select2::class, [
    'data' => ArrayHelper::map($node::find()->select([$primaryKey, $nameKey])->all(), $primaryKey, $nameKey),
]) ?>
<?=Html::submitButton(\Yii::t('app', "交换节点位置"), ['class' => "btn btn-primary"]) ?>
<?php ActiveForm::end(); ?>

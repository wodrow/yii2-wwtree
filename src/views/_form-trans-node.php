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
 * @var \yii\base\Model $node
 * @var FormTransNode $trans_node_form
 */
use kartik\form\ActiveForm;
use yii\helpers\Html;
use common\members\wodrow\widgets\tree\FormTransNode;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
?>

<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_INLINE]); ?>
<?=$form->field($trans_node_form, 'tnid')->widget(Select2::class, [
    'data' => ArrayHelper::map($node::find()->select(['id', 'name'])->all(), 'id', 'name'),
]) ?>
<?=Html::submitButton(\Yii::t('app', "交换节点位置"), ['class' => "btn btn-primary"]) ?>
<?php ActiveForm::end(); ?>

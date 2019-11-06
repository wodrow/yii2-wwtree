<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-1-18
 * Time: 上午11:51
 */
/**
 * @var \yii\web\View $this
 * @var array $tree
 * @var \yii\db\ActiveRecord|\wodrow\yii2wwtree\TreeBehavior $node
 */
use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$primaryKey = $node->primaryKeyAttribute;
$parentKey = $node->parentKeyAttribute;
$nameKey = $node->nameKeyAttribute;
$iconKey = $node->iconKeyAttribute;
$iconColorKey = $node->iconColorKeyAttribute;
$sortKey = $node->sortKeyAttribute;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <?php
        $label = "";
        if ($node->isNewRecord){
            $label = \Yii::t('app', "新建");
            if (!$node->$parentKey){
                $label .= \Yii::t('app', "根");
            }
        }else{
            $label .= \Yii::t('app', "修改");
        }
        $label .= \Yii::t('app', "节点");
        echo $label;
        ?>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-6">
                <?=$form->field($node, $primaryKey)->textInput(['readonly' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?php echo $form->field($node, $iconKey)->textInput()->hint(\Yii::t('app', "详见").Html::a('fontawesome icon', "http://www.fontawesome.com.cn/faicons/")) ?>
                <?php // echo $form->field($node, 'icon')->widget(Iconpicker::class, ['iconset' => "fontawesome"])->hint(\Yii::t('app', "详见").Html::a('fontawesome icon', "http://www.fontawesome.com.cn/faicons/")) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <?=$form->field($node, $parentKey)->widget(Select2::class, [
                    'data' => ArrayHelper::merge(['' => "根节点"], ArrayHelper::map($node::find()->select([$primaryKey, $nameKey])->all(), $primaryKey, $nameKey)),
                ]) ?>
            </div>
            <div class="col-xs-6">
                <?=$form->field($node, $iconColorKey)->widget(\kartik\color\ColorInput::class) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <?=$form->field($node, $sortKey)->textInput(['readonly' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?=$form->field($node, $nameKey)->textInput() ?>
            </div>
        </div>
        <?=$this->render($custom_field_view, ['node' => $node, 'form' => $form]) ?>
    </div>
    <div class="panel-footer">
        <?=Html::submitButton($node->isNewRecord?\Yii::t('app', "新建"):\Yii::t('app', "修改"), ['class' => "btn btn-primary"]) ?>
        <?=Html::resetButton(\Yii::t('app', "重置"), ['class' => "btn btn-warning"]) ?>
    </div>
</div>
<?php $form = ActiveForm::end(); ?>

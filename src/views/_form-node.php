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
 * @var \yii\base\Model $node
 */
use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <?php
        $label = "";
        if ($node->isNewRecord){
            $label = \Yii::t('app', "新建");
            if (!$node->pid){
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
                <?=$form->field($node, 'id')->textInput(['readonly' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?php echo $form->field($node, 'icon')->textInput()->hint(\Yii::t('app', "详见").Html::a('fontawesome icon', "http://www.fontawesome.com.cn/faicons/")) ?>
                <?php // echo $form->field($node, 'icon')->widget(Iconpicker::class, ['iconset' => "fontawesome"])->hint(\Yii::t('app', "详见").Html::a('fontawesome icon', "http://www.fontawesome.com.cn/faicons/")) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <?=$form->field($node, 'pid')->widget(Select2::class, [
                        'data' => ArrayHelper::map($node::find()->select(['id', 'name'])->all(), 'id', 'name'),
                ]) ?>
            </div>
            <div class="col-xs-6">
                <?=$form->field($node, 'icon_color')->widget(\kartik\color\ColorInput::class) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <?=$form->field($node, 'sort')->textInput(['readonly' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?=$form->field($node, 'name')->textInput() ?>
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

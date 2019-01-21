<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-1-21
 * Time: 上午11:11
 */

/**
 * @var \yii\web\View $this
 * @var array $tree
 * @var \yii\base\Model $node
 * @var FormSearch $node_search_form
 */

use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\icons\Icon;
use common\members\wodrow\widgets\tree\FormSearch;

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'type' => ActiveForm::TYPE_INLINE,
    'fieldConfig' => ['template' => '{input}'],
]); ?>
<div class="input-group">
    <?php //echo Html::input('text', '', '', ['class' => "form-control input-sm", 'placeholder' => "搜索"]) ?>
    <?=$form->field($node_search_form, 'key', [
        'template' => "{label}{input}{hint}{error}",
    ])->textInput([
        'class' => "form-control input-sm",
    ])->label(false) ?>
    <span class="input-group-btn">
        <?= Html::submitButton(Icon::show('search'), ['class' => "btn btn-default btn-sm"]) ?>
    </span>
</div>
<?php ActiveForm::end(); ?>

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
 * @var \yii\base\Model $node
 */
use yii\helpers\Html;
use kartik\icons\Icon;
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
            if ($v['id'] == Yii::$app->request->get('id')){
                $active = 1;
            }
        ?>
        <?=Html::a(Html::tag('li', Html::tag('span', $ns, ['class' => "ww-ns"]).Icon::show($v['icon'], ['style' => ['color' => $v['icon_color']]]).$v['name'], ['class' => $active?"active":""]), ["/".Yii::$app->controller->route, 'id'=>$v['id']]) ?>
        <?php if (isset($v['_child'])): ?>
            <?=$this->render('tree-view', ['tree' => $v['_child'], 'node' => $node]) ?>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
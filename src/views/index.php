<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 18-11-26
 * Time: 上午8:59
 */
/**
 * @var \yii\web\View $this
 * @var array $tree
 * @var \yii\base\Model $node
 * @var FormTransNode $trans_node_form
 * @var FormSearch $node_search_form
 * @var string $custom_field_view
 */
use common\members\wodrow\widgets\tree\FormTransNode;
use common\members\wodrow\widgets\tree\FormSearch;
?>

<div class="ww-tree">
    <div class="row">
        <div class="col-sm-4">
            <?=$this->render('_form-list', ['tree' => $tree, 'node' => $node, 'node_search_form' => $node_search_form]) ?>
        </div>
        <div class="col-sm-8">
            <?=$this->render('_form-node', ['tree' => $tree, 'node' => $node, 'custom_field_view' => $custom_field_view]) ?>
            <?php
            if (!$node->isNewRecord){
                echo $this->render('_form-trans-node', ['trans_node_form' => $trans_node_form, 'node' => $node]);
            }
            ?>
        </div>
    </div>
</div>
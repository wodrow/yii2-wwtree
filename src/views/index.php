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
 * @var \yii\db\ActiveRecord|\wodrow\yii2wwtree\TreeBehavior $node
 * @var string $ajaxUrl
 * @var \wodrow\yii2wwtree\FormTransNode $trans_node_form
 * @var \wodrow\yii2wwtree\FormSearch $node_search_form
 * @var string $custom_field_view
 */
?>

<div class="ww-tree">
    <div class="row">
        <div class="col-sm-4">
            <?=$this->render('_form-list', ['tree' => $tree, 'node' => $node, 'node_search_form' => $node_search_form]) ?>
        </div>
        <div class="col-sm-8">
            <?=$this->render('_form-node', ['tree' => $tree, 'node' => $node, 'custom_field_view' => $custom_field_view, 'ajaxUrl' => $ajaxUrl]) ?>
            <?php
            if (!$node->isNewRecord){
                echo $this->render('_form-trans-node', ['trans_node_form' => $trans_node_form, 'node' => $node, 'ajaxUrl' => $ajaxUrl]);
            }
            ?>
        </div>
    </div>
</div>
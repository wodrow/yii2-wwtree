<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-1-18
 * Time: 上午11:41
 */
/**
 * @var \yii\web\View $this
 * @var array $tree
 * @var \yii\base\Model $node
 * @var FormSearch $node_search_form
 */
use mootensai\components\JsBlock;
use common\members\wodrow\widgets\tree\FormSearch;
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3">
                <?=\Yii::t('app', "根") ?>
            </div>
            <div class="col-xs-9">
                <?=$this->render('_form-search', ['tree' => $tree, 'node' => $node, 'node_search_form' => $node_search_form]) ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="ww-tree-ls">
            <?=$this->render('tree-view', ['tree' => $tree, 'node' => $node]) ?>
        </div>
    </div>
    <div class="panel-footer">
        <?=$this->render('_list-footer', ['tree' => $tree, 'node' => $node]) ?>
    </div>
</div>

<?php JsBlock::begin(); ?>
    <script>
        $(document).ready(function(){
            var node_id = "<?=$node->id ?>";
            if (node_id){
                scrollToLocation($('.ww-tree-ls'), 'li.active');
            }
        });
    </script>
<?php JsBlock::end(); ?>
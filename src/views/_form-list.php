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
 * @var \yii\db\ActiveRecord|\wodrow\yii2wwtree\TreeBehavior $node
 * @var \wodrow\yii2wwtree\FormSearch $node_search_form
 */
$primaryKey = $node->primaryKeyAttribute;
$parentKey = $node->parentKeyAttribute;
$nameKey = $node->nameKeyAttribute;
$iconKey = $node->iconKeyAttribute;
$iconColorKey = $node->iconColorKeyAttribute;
$sortKey = $node->sortKeyAttribute;

use wodrow\yii2wtools\tools\JsBlock;

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
            let node_id = "<?=$node->$primaryKey ?>";
            if (node_id){
                let mainContainer = $('.ww-tree-ls'),
                scrollToContainer = mainContainer.find('li.active');
                mainContainer.animate({
                    scrollTop: scrollToContainer.offset().top - mainContainer.offset().top + mainContainer.scrollTop(),
                    scrollLeft: scrollToContainer.offset().left - mainContainer.offset().left + mainContainer.scrollLeft()
                }, 2000);
            }
        });
    </script>
<?php JsBlock::end(); ?>
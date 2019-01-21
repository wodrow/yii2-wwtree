<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 18-11-23
 * Time: 下午6:41
 */

namespace wodrow\yii2wwtree;


use yii\helpers\Url;
use yii\base\Widget;
use yii\base\Model;

class TreeWidget extends Widget
{
    public $treeModelClass;
    public $custom_field_view = '_form-node-custom';

    /**
     * @var Model $node
     */
    public $node;

    /**
     * @var array $list
     */
    private $list;

    /**
     * @var array $tree
     */
    private $tree;

    /**
     * @var FormSearch
     */
    public $formSearch;

    private static function makePnodes($node, &$arr = null)
    {
        $owner = $node;
        if (!$owner){
            return null;
        }
        if (!$owner->pid){
            return null;
        }
        $p = $owner::find()->where(['id' => $owner->pid])->one();
        $arr[] =$p;
        self::makePnodes($p, $arr);
    }

    /**
     * @throws
     */
    public function init()
    {
        parent::init();
        $modelClass = $this->treeModelClass;
        $node_search_form = new FormSearch();
        if ($node_search_form->load(\Yii::$app->request->get())&&$node_search_form->validate()){
            $key = $node_search_form->key;
            $a = $modelClass::find()->orderBy(['sort' => SORT_ASC])->where(['like', 'name', $key])->all();
            $ids = [];
            foreach ($a as $k => $v){
                $ids[] = $v->id;
                $arr = [];
                self::makePnodes($v, $arr);
                foreach ($arr as $k1 => $v1){
                    if (!in_array($v1->id, $ids)){
                        $a[] = $v1;
                    }
                }
            }
            foreach ($a as $k => $v){
                $a[$k]->name = str_replace($key, "<b>".$key."</b>", $a[$k]->name);
                $a[$k] = $a[$k]->toArray();
            }
            $this->list = $a;
        }else{
            $this->list = $modelClass::find()->orderBy(['sort' => SORT_ASC])->asArray()->all();
        }
        $this->tree = \common\members\wodrow\tools\Tree::list2tree($this->list, null);
        \common\members\wodrow\tools\Tree::get_tree_node_sort($this->tree);
        \common\members\wodrow\tools\Tree::getPreStyle($this->tree);
        $this->formSearch = $node_search_form;

        $this->node = new $modelClass();
        $this->node->icon = "folder-open";
        $this->node->icon_color = "#00ffff";
        if (\Yii::$app->request->get('add-for')) {
            $this->node->pid = \Yii::$app->request->get('add-for');
            \Yii::$app->request->get('id');
        }

        if (\Yii::$app->request->get('id')){
            $this->node = $modelClass::findOne(\Yii::$app->request->get('id'));
            switch (\Yii::$app->request->get('sort_action')){
                case "up":
                    $this->node->sortUp();
                    break;
                case "down":
                    $this->node->sortDown();
                    break;
                case "left":
                    $this->node->sortLeft();
                    break;
                case "right":
                    $this->node->sortRight();
                    break;
            }
        }

        if (\Yii::$app->request->get('delete-for')){
            $this->node = $modelClass::findOne(\Yii::$app->request->get('delete-for'));
            if (!$this->node->delete()){
                \Yii::$app->session->addFlash("error", \common\members\wodrow\tools\Model::getModelError($this->node));
            }else{
                \Yii::$app->session->addFlash("success", "删除成功");
                $url = Url::to(['/'.\Yii::$app->controller->route]);
                \Yii::$app->response->redirect($url)->send();
                exit;
            }
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        TreeAsset::register($this->view);
        $old_pid = $this->node->pid;
        if ($this->node->load(\Yii::$app->request->post())&&$this->node->validate()){
            if (!$this->node->isNewRecord){
                if ($old_pid != $this->node->pid){
                    $o = $this->node;
                    $models = $o::find()->where(['pid' => $old_pid])->andWhere(['>', 'sort', $o->sort])->orderBy(['sort' => SORT_ASC])->all();
                    foreach ($models as $k => $v){
                        $v->sort --;
                        $v->save();
                    }
                    $this->node->append(false);
                }
            }else{
                $this->node->append(false);
            }
            if (!$this->node->save()){
                \Yii::$app->session->addFlash("error", \common\members\wodrow\tools\Model::getModelError($this->node));
            }else{
                \Yii::$app->session->addFlash("success", "保存成功");
                $url = Url::to(['/'.\Yii::$app->controller->route, 'id' => $this->node->id]);
                \Yii::$app->response->redirect($url)->send();
                exit;
            }
        }
        $trans_node_form = new FormTransNode();
        $trans_node_form->modelClass = $this->treeModelClass;
        $trans_node_form->slid = $this->node->id;
        if ($trans_node_form->load(\Yii::$app->request->post())&&$trans_node_form->validate()){
            $trans_node_form->doTrans();
        }
        return $this->render('index', [
            'tree' => $this->tree,
            'node' => $this->node,
            'trans_node_form' => $trans_node_form,
            'node_search_form' => $this->formSearch,
            'custom_field_view' => $this->custom_field_view,
        ]);
    }
}
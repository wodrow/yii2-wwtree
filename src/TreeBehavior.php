<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-1-18
 * Time: 下午4:41
 */

namespace wodrow\yii2wwtree;


use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\Url;
use yii\validators\Validator;
use yii\web\ForbiddenHttpException;

/**
 * Class TreeBehavior
 * @package wodrow\yii2wwtree
 *
 * @property ActiveRecord $parent
 * @property ActiveRecord[] $childs
 *
 * @property-read boolean $canUp
 * @property-read boolean $canDown
 * @property-read boolean $canLeft
 * @property-read boolean $canRight
 */
class TreeBehavior extends AttributeBehavior
{
    public function attach($owner)
    {
        parent::attach($owner);
        $owner->validators[] = Validator::createValidator(Loop::class, $this->owner, $this->parentKeyAttribute, ['parent_for_attribute' => $this->primaryKeyAttribute, 'parent_model_linkname' => 'parent']);
    }

    public $primaryKeyAttribute = "id";
    public $parentKeyAttribute = 'pid';
    public $nameKeyAttribute = 'name';
    public $sortKeyAttribute = 'sort';
    public $iconKeyAttribute = 'icon';
    public $iconColorKeyAttribute = 'icon_color';

    public function getCanAddChild()
    {
        if ($this->owner->isNewRecord){
            return false;
        }else{
            return true;
        }
    }

    public function getCanDelete()
    {
        if ($this->owner->isNewRecord){
            return false;
        }else{
            return true;
        }
    }

    public function getCanUp()
    {
        $owner = $this->owner;
        if ($owner->isNewRecord){
            return false;
        }else{
            $parentKey = $this->parentKeyAttribute;
            $sortKey = $this->sortKeyAttribute;
            if ($owner::find()->where([$parentKey => $owner->$parentKey])->andWhere(['<', $sortKey, $owner->$sortKey])->one()){
                return true;
            }else{
                return false;
            }
        }
    }

    public function sortUp()
    {
        $owner = $this->owner;
        if (!$owner->canUp){
            throw new ForbiddenHttpException(\Yii::t('app', "不能上移"));
        }else{
            $primaryKey = $this->primaryKeyAttribute;
            $parentKey = $this->parentKeyAttribute;
            $sortKey = $this->sortKeyAttribute;
            $up = $owner::find()->where([$parentKey => $owner->$parentKey])->andWhere(['<', $sortKey, $owner->$sortKey])->orderBy([$sortKey => SORT_DESC])->one();
            $tmp = $up->$sortKey;
            $up->$sortKey = $owner->$sortKey;
            $owner->$sortKey = $tmp;
            $trans = $owner->db->beginTransaction();
            try{
                $up->save();
                $owner->save();
                $trans->commit();
            }catch (Exception $e){
                $trans->rollBack();
                throw $e;
            }
            \Yii::$app->session->addFlash("success", \Yii::t('app', "上移成功"));
            $url = Url::to(['/'.\Yii::$app->controller->route, 'id' => $owner->$primaryKey]);
            \Yii::$app->response->redirect($url)->send();
            exit;
        }
    }

    public function getCanDown()
    {
        $owner = $this->owner;
        if ($owner->isNewRecord){
            return false;
        }else{
            $parentKey = $this->parentKeyAttribute;
            $sortKey = $this->sortKeyAttribute;
            if ($owner::find()->where([$parentKey => $owner->$parentKey])->andWhere(['>', $sortKey, $owner->$sortKey])->one()){
                return true;
            }else{
                return false;
            }
        }
    }

    public function sortDown()
    {
        $owner = $this->owner;
        if (!$owner->canDown){
            throw new ForbiddenHttpException(\Yii::t('app', "不能下移"));
        }else{
            $primaryKey = $this->primaryKeyAttribute;
            $parentKey = $this->parentKeyAttribute;
            $sortKey = $this->sortKeyAttribute;
            $down = $owner::find()->where([$parentKey => $owner->$parentKey])->andWhere(['>', $sortKey, $owner->$sortKey])->orderBy([$sortKey => SORT_ASC])->one();
            $tmp = $down->$sortKey;
            $down->$sortKey = $owner->$sortKey;
            $owner->$sortKey = $tmp;
            $trans = $owner->db->beginTransaction();
            try{
                $down->save();
                $owner->save();
                $trans->commit();
            }catch (Exception $e){
                $trans->rollBack();
                throw $e;
            }
            \Yii::$app->session->addFlash("success", \Yii::t('app', "下移成功"));
            $url = Url::to(['/'.\Yii::$app->controller->route, 'id' => $owner->$primaryKey]);
            \Yii::$app->response->redirect($url)->send();
            exit;
        }
    }

    public function getCanLeft()
    {
        $owner = $this->owner;
        if ($owner->isNewRecord){
            return false;
        }else{
            $primaryKey = $this->primaryKeyAttribute;
            $parentKey = $this->parentKeyAttribute;
            if ($owner::find()->where([$primaryKey => $owner->$parentKey])->one()){
                return true;
            }else{
                return false;
            }
        }
    }

    public function sortLeft()
    {
        $owner = $this->owner;
        if (!$owner->canLeft){
            throw new ForbiddenHttpException(\Yii::t('app', "不能左移"));
        }else{
            $trans = $owner->db->beginTransaction();
            try{
                $primaryKey = $this->primaryKeyAttribute;
                $parentKey = $this->parentKeyAttribute;
                $this->afMove();
                $parent = $owner::find()->where([$primaryKey => $owner->$parentKey])->one();
                $owner->$parentKey = $parent->$parentKey;
                $this->append(true);
                $trans->commit();
            }catch (Exception $e){
                $trans->rollBack();
                throw $e;
            }
            \Yii::$app->session->addFlash("success", \Yii::t('app', "左移成功"));
            $url = Url::to(['/'.\Yii::$app->controller->route, 'id' => $owner->$primaryKey]);
            \Yii::$app->response->redirect($url)->send();
            exit;
        }
    }

    public function getCanRight()
    {
        return $this->canUp;
    }

    public function sortRight()
    {
        $owner = $this->owner;
        if (!$owner->canRight){
            throw new ForbiddenHttpException(\Yii::t('app', "不能右移"));
        }else{
            $trans = $owner->db->beginTransaction();
            try{
                $primaryKey = $this->primaryKeyAttribute;
                $parentKey = $this->parentKeyAttribute;
                $sortKey = $this->sortKeyAttribute;
                $this->afMove();
                $up = $owner::find()->where([$parentKey => $owner->$parentKey])->andWhere(['<', $sortKey, $owner->$sortKey])->orderBy([$sortKey => SORT_DESC])->one();
                $owner->$parentKey = $up->$primaryKey;
                $this->append(true);
                $trans->commit();
            }catch (Exception $e){
                $trans->rollBack();
                throw $e;
            }
            \Yii::$app->session->addFlash("success", \Yii::t('app', "右移成功"));
            $url = Url::to(['/'.\Yii::$app->controller->route, 'id' => $owner->$primaryKey]);
            \Yii::$app->response->redirect($url)->send();
            exit;
        }
    }

    public function append($is_save = true)
    {
        $parentKey = $this->parentKeyAttribute;
        $sortKey = $this->sortKeyAttribute;
        $owner = $this->owner;
        $owner->$sortKey = 0;
        if (!$owner->$parentKey){
            $owner->$parentKey = null;
        }
        $last = $owner::find()->where([$parentKey => $owner->$parentKey])->orderBy([$sortKey => SORT_DESC])->one();
        if ($last){
            $owner->$sortKey = $last->$sortKey + 1;
        }
        if ($is_save)$owner->save();
    }

    public function afMove()
    {
        $parentKey = $this->parentKeyAttribute;
        $sortKey = $this->sortKeyAttribute;
        $owner = $this->owner;
        $models = $owner::find()->where([$parentKey => $owner->$parentKey])->andWhere(['>', $sortKey, $owner->$sortKey])->orderBy([$sortKey => SORT_ASC])->all();
        foreach ($models as $k => $v){
            $v->$sortKey --;
            $v->save();
        }
    }

    public function remove()
    {
        $owner = $this->owner;
        $trans = $owner->db->beginTransaction();
        try{
            $this->afMove();
            $this->removeR();
            $owner->delete();
            $trans->commit();
            return true;
        }catch (Exception $e){
            $trans->rollBack();
            return false;
        }
    }

    public function removeR()
    {
        $owner = $this->owner;
        foreach ($owner->childs as $k => $v){
            $v->delete();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        $owner = $this->owner;
        return $owner->hasOne($owner::className(), [$this->primaryKeyAttribute => $this->parentKeyAttribute]);
    }

    /**
     * @return \yii\db\ActiveQuery[]
     */
    public function getChilds()
    {
        $owner = $this->owner;
        return $owner->hasMany($owner::className(), [$this->parentKeyAttribute => $this->primaryKeyAttribute]);
    }
}
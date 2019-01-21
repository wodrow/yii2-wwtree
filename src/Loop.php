<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-1-21
 * Time: 下午6:06
 */

namespace wodrow\yii2wwtree;


use yii\db\ActiveRecord;
use yii\validators\Validator;

/**
 * Class Loop
 * @package common\components\validators
 * @desc 回环验证
 */
class Loop extends Validator
{
    public $parent_for_attribute = 'id';
    public $parent_model_linkname = 'p';

    /**
     * @param ActiveRecord $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $parent_for_attribute = $this->parent_for_attribute;
        $search = $model->$parent_for_attribute;
        if ($search == $model->$attribute){
            $bool = true;
        }else{
            /**
             * @var ActiveRecord $class_name
             */
            $class_name = get_class($model);
            $parent = $class_name::findOne([$parent_for_attribute => $model->$attribute]);
            $bool = $this->validateSearch($search, $parent);
        }
        if ($bool){
            $this->addError($model, $attribute, $attribute . \Yii::t('app', "产生回环"));
        }
    }

    /**
     * @param string $search
     * @param ActiveRecord $parent
     * @return bool
     */
    protected function validateSearch($search, $parent)
    {
        $parent_for_attribute = $this->parent_for_attribute;
        $parent_model_linkname = $this->parent_model_linkname;
        if ($parent){
            if ($parent->$parent_for_attribute == $search){
                return true;
            }else{
                return $this->validateSearch($search, $parent->$parent_model_linkname);
            }
        }else{
            return false;
        }
    }
}
# yii2-wwtree

### 使用方式

#### 安装
```html
composer require wodrow/yii2-wwtree dev-master
```

##### 模型
```html
public function behaviors()
{
    return [
        'tree' => [
            'class' => \wodrow\yii2wwtree\TreeBehavior::class,
        ],
    ];
}

public function rules()
{
    $r = parent::rules();
    $rules = [
        ['pid', \wodrow\yii2wwtree\Loop::class],
    ];
    $rules = ArrayHelper::merge($r, $rules);
    return $rules;
}

/**
 * @return \yii\db\ActiveQuery
 */
public function getP()
{
    return $this->hasOne(self::class, ['id' => 'pid']);
}

/**
 * @return \yii\db\ActiveQuery
 */
public function getChilds()
{
    return $this->hasMany(self::class, ['pid' => 'id']);
}

public function afterDelete()
{
    parent::afterDelete();
    $this->afMove();
    foreach ($this->childs as $k => $v) {
        $v->delete();
    }
}
```

##### 视图
```html
<?=wodrow\yii2wwtree\TreeWidget::widget([
    'treeModelClass' => "your model class",
    'custom_field_view' => "add your extend field view",
]) ?>
```

### 注意
```html
数据表必须要有id, pid(父级), name, sort, icon, icon_color这六个字段，其他字段根据需要自己添加, 使用它生成的模型
```

### 截图

![kiEcj0.png](https://s2.ax1x.com/2019/01/21/kiEcj0.png)
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
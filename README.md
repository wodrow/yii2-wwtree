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
            'primaryKeyAttribute' => 'your_pk_id_filed_name',
            'parentKeyAttribute' => 'your_parent_id_filed_name',
            'nameKeyAttribute' => 'your_name_filed_name',
            'sortKeyAttribute' => 'your_sort_filed_name',
            'iconKeyAttribute' => 'your_icon_filed_name',
            'iconColorKeyAttribute' => 'your_icon_color_filed_name',
        ],
    ];
}
```

##### 视图
```html
<?=wodrow\yii2wwtree\TreeWidget::widget([
    'treeModelClass' => "your model class",
    // 'custom_field_view' => "@your/extend/view",
]) ?>
```

### 注意
```html
数据表必须要有id, pid(父级), name, sort, icon, icon_color这六个字段，字段名可以是TreeBehavior配置的字段名，其他字段根据需要自己添加, 在custom_field_view视图里可以处理添加的字段，使用它生成的模型
```

### 截图
![kiEcj0.png](https://i.loli.net/2019/11/06/jZht9qoOsE6ma3L.jpg)
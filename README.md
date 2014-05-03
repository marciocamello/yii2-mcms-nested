MCMS Nested Sortable
====================
Nested Sortable based in nestedSortable jQuery Plugin

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist marciocamello/yii2-mcms-nested "*"
```

or add

```
"marciocamello/yii2-mcms-nested": "*"
```

to the require section of your `composer.json` file.


List Sortable
-----

```php

echo \mcms\nested\NestedSortable::widget([
	'model' => Menu::className(),
	'url' => 'nested/save-sortable',
	'expand' => true,
	'pluginOptions' => [
		'maxDepth' => 2
	]
]);

```

Action
---------

```php

public function actions()
	{
		return [
			'save-sortable' => [
				'class' => 'mcms\nested\NestedSortableAction',
				//'scenario'=>'editable',  //optional
				'modelclass' => Categories::className(),
			],
		];
	}
	
```

<?php

/**
 * @inheritdoc
 */
namespace mcms\nested;

use yii\web\AssetBundle;

\Yii::setAlias('@nested', dirname(__FILE__));

/**
 * @inheritdoc
 */
class NestedSortableAsset extends AssetBundle
{

	public $sourcePath = '@nested/assets/';

	public $css = [
		'nested/jquery.nestable.css',
	];

	public $js = [
		'nested/functions.js',
		'nested/jquery.nestable.js',
	];

	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapPluginAsset',
	];

}
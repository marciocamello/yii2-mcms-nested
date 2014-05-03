<?php

/**
 * @inheritdoc
 */
namespace mcms\nested;
use yii\base\View;
use yii\helpers\Json;

/**
 * @inheritdoc
 */
class NestedSortable extends \yii\base\Widget
{

	/*
	 listNodeName    : 'ol',
            itemNodeName    : 'li',
            rootClass       : 'dd',
            listClass       : 'dd-list',
            itemClass       : 'dd-item',
            dragClass       : 'dd-dragel',
            handleClass     : 'dd-handle',
            collapsedClass  : 'dd-collapsed',
            placeClass      : 'dd-placeholder',
            emptyClass      : 'dd-empty',
            expandBtnHTML   : '<button data-action="expand">Expand</button>',
            collapseBtnHTML : '<button data-action="collapse">Collapse</button>',
            group           : 0,
            maxDepth        : 5,
            threshold       : 20
	 */

	/**
	 * @see NestedSortable
	 * @var string
	 */
	public $group = 0;

	/**
	 * @see NestedSortable
	 * @var string
	 */
	public $maxDepth = 5;

	/**
	 * @see NestedSortable
	 * @var string
	 */
	public $threshold = 20;

	/**
	 * @see NestedSortable
	 * @var string
	 */
	public $url = './save-sortable';

	/**
	 * @see NestedSortable
	 * @var string
	 */
	public $pluginOptions = [];

	/**
	 * @see NestedSortable
	 * @var string
	 */
	public $model = null;

	/**
	 * @see NestedSortable
	 * @var string
	 */
	public $expand = false;

	/**
	 * @see NestedSortable
	 * @var string
	 */
	public $expandMenu = '
		<menu id="nestable-menu">
			<button type="button" data-action="expand-all">Expand All</button>
			<button type="button" data-action="collapse-all">Collapse All</button>
		</menu>';



	/**
 	* @see NestedSortable
 	* @see Init extension default
 	*/
	public function init()
	{
		parent::init();
		$this->registerAssets();
	}

    public function run()
    {

		$view = $this->getView();

		$view->registerJs("
			var urlSortable = '$this->url';
		",$view::POS_END);

		$view->registerJs("

		/* The output is ment to update the nestableMenu-output textarea
		* So this could probably be rewritten a bit to only run the menu_updatesort function onchange
		*/

		var updateOutput = function(e)
		{
			var list   = e.length ? e : $(e.target),
				output = list.data('output');
			if (window.JSON) {
				output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
				menu_updatesort(window.JSON.stringify(list.nestable('serialize')));
			} else {
				output.val('JSON browser support required for this demo.');
			}
		};

		",$view::POS_READY);

		$this->registerScript();
		return $this->renderNested();

    }

	public function registerScript()
	{
		$options = false;

		$view = $this->getView();

		foreach($this->pluginOptions as $name => $value)
		{
			$options .= $name.":".Json::encode($value).",";
		}

		$view->registerJs("jQuery('#$this->id').nestable({".$options."}).on('change', updateOutput);",$view::POS_READY);
		$view->registerJs("updateOutput($('#$this->id').data('output', $('#$this->id-output')));",$view::POS_READY);

		if($this->expand==true)
		{
			$view->registerJs("

				$('#nestable-menu').on('click', function(e)
				{
					var target = $(e.target),
						action = target.data('action');
					if (action === 'expand-all') {
						$('.dd').nestable('expandAll');
					}
					if (action === 'collapse-all') {
						$('.dd').nestable('collapseAll');
					}
				});

			",$view::POS_READY);
		}

	}

	public function showNested($parentID)
	{
		$modelclass=$this->model;

		$model = $modelclass::find()->where([
			'parent' => $parentID
		])->orderBy('order');

		$nested = false;

		if ($model->count() > 0) {
			$nested .= "<ol class='dd-list'>";
			foreach($model->all() as $row){
				$nested .= "<li class='dd-item' data-id='{$row->id}'>";
				$nested .= "<div class='dd-handle'>{$row->id}: {$row->name}</div>";
				$this->showNested($row->id);
				$nested .= "</li>";
			}
			$nested .= "</ol>";
		}

		return $nested;
	}

	public function renderNested()
	{
		$modelclass=$this->model;

		$model = $modelclass::find()->where([
			'parent' => 0
		])->orderBy('order');

		$nested = false;

		// Feedback div for update hierarchy to DB
		// IMPORTANT: This needs to be here! But you can remove the style
		$nested .= "<div id='sortDBfeedback' style='border:1px solid #eaeaea; padding:10px; margin:15px;'></div>";

		if($this->expand==true)
		{
			$nested .= $this->expandMenu;
		}

		$nested .= "<div class='cf nestable-lists'>";
		$nested .= "<div class='dd' id='$this->id'>";
		$nested .= "<ol class='dd-list'>";

		foreach($model->all() as $row){
			$nested .= "<li class='dd-item' data-id='{$row->id}'>";
			$nested .= "<div class='dd-handle'>{$row->id}: {$row->name}</div>";
			$nested .=$this->showNested($row->id);
			$nested .= "</li>";
		}

		$nested .= "</ol>";
		$nested .= "</div>";
		$nested .= "</div>";

		return $nested;

		// Script output for debuug
		//echo "<textarea id='$this->id-output'></textarea>";
	}

	/**
	 * @see NestedSortable
	 * @see Register assets from this extension and yours types
	 */
	public function registerAssets()
	{
		$this->view = \Yii::$app->getView();
		NestedSortableAsset::register($this->view);
	}
}
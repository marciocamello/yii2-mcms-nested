<?php

namespace mcms\nested;

use yii\base\Action;
use yii\web\NotFoundHttpException;

class NestedSortableAction extends Action
{
	public $modelclass;
	public $scenario='';

	public function run()
	{
		// Get the JSON string
		$jsonstring = $_GET['jsonstring'];

		// Decode it into an array
		$jsonDecoded = json_decode($jsonstring, true, 64);

		// Run the function above
		$readbleArray = $this->parseJsonArray($jsonDecoded);

		// Loop through the "readable" array and save changes to DB
		foreach ($readbleArray as $key => $value) {

			// $value should always be an array, but we do a check
			if (is_array($value)) {

				$modelclass=$this->modelclass;
				$model= $modelclass::find()->where([
					'id' => $value['id']
				])->one();
				if($this->scenario){
					$model->setScenario($this->scenario);
				}

				$model->order = $key;
				$model->parent = $value['parentID'];
				$model->save(false);
			}
		}

		// Echo status message for the update
		echo \Yii::t('app',"The list was updated ").date("y-m-d H:i:s")."!";
	}

	public function parseJsonArray($jsonArray, $parentID = 0)
	{
		$return = array();
		foreach ($jsonArray as $subArray) {
			$returnSubSubArray = array();
			if (isset($subArray['children'])) {
				$returnSubSubArray = $this->parseJsonArray($subArray['children'], $subArray['id']);
			}
			$return[] = array('id' => $subArray['id'], 'parentID' => $parentID);
			$return = array_merge($return, $returnSubSubArray);
		}

		return $return;
	}
}
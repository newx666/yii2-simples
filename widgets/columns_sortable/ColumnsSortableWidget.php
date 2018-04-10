<?php
/**
 * Created by PhpStorm.
 * Date: 09.12.15
 * Time: 15:28
 */

namespace backend\components\widgets\columns_sortable;


use yii\base\Exception;
use yii\base\Widget;

class ColumnsSortableWidget extends Widget
{
	public $modelClass;
	public $action;
	public $attribute;
	public $idModelAttribute = 'id';

	public function init(){
		parent::init();
		if(!$this->modelClass || !$this->action || !$this->attribute){
			throw new Exception('Params modelClass, attribute and action required');
		}
	}

	public function run(){
		return $this->render('main', [
			'modelClass' => $this->modelClass,
			'action' => $this->action,
			'attribute' => $this->attribute,
			'idModelAttribute' => $this->idModelAttribute,
		]);
	}
}
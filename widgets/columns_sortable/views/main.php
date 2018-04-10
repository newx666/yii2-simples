<?php
/**
 * Created by PhpStorm.
 * Date: 03.12.15
 * Time: 0:22
 */
use backend\components\widgets\columns_sortable\assets\ColumnsSortableAsset;
use yii\helpers\Json;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $modelClass string */
/* @var $action [] */
/* @var $attribute string */
/* @var $idModelAttribute string */

$widgetParams = [
	'modelClass' => $modelClass,
	'actionUrl' => Url::to($action),
	'attribute' => $attribute,
	'idModelAttribute' => $idModelAttribute,
];

$this->registerJs('window.sortWidgetParams=' . Json::encode($widgetParams), $this::POS_BEGIN);

ColumnsSortableAsset::register($this);
?>
<button id="to-resort" type="button" class="btn btn-default">Пересортировать</button>
<?php
/**
 * Created by PhpStorm.
 * Date: 09.12.15
 * Time: 15:31
 */

namespace backend\components\widgets\columns_sortable\assets;


use yii\web\AssetBundle;

class ColumnsSortableAsset extends AssetBundle
{
	public function init()
	{
		$this->sourcePath = __DIR__ . '/../static';
	}

	public $baseUrl = '@web';
	public $js = [
		'js/columns_sortable.js'
	];
	public $css = [
		'css/columns_sortable.css'
	];
	public $depends = [
		'common\assets\JQueryUIAsset',
	];
}
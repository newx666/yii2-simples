<?php
/**
 * Created by PhpStorm.
 * Date: 03.12.15
 * Time: 1:46
 */

namespace backend\components\widgets\gallery_items\assets;


use common\assets\JQueryUIAsset;
use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;

class GalleryItemsAsset extends AssetBundle
{
	public function init()
	{
		$this->sourcePath = __DIR__ . '/../static';
	}

	public $baseUrl = '@web';
	public $js = [
		'js/gallery_items.js'
	];
	public $css = [
		'css/gallery_items.css'
	];
	public $depends = [
		'yii\web\JqueryAsset',
		'common\assets\JQueryUIAsset',
	];
}
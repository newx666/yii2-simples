<?php

namespace backend\components\widgets\image_selector\assets;

use yii\web\AssetBundle;

class ImageSelectorAsset extends AssetBundle
{

	public function init(){
		$this->sourcePath = __DIR__ . '/../static';
	}
	public $baseUrl = '@web';
	public $js = [
		'js/image_selector.js'
	];
	public $css = [
		'css/image-selector.css'
	];
	public $depends = [
		'yii\web\JqueryAsset',
	];
}
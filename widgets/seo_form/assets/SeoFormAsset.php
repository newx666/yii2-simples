<?php
/**
 * Created by PhpStorm.
 * Date: 15.12.15
 * Time: 1:59
 */

namespace backend\components\widgets\seo_form\assets;


use yii\web\AssetBundle;

class SeoFormAsset extends AssetBundle
{
	public function init()
	{
		$this->sourcePath = __DIR__ . '/../static';
	}

	public $baseUrl = '@web';
	public $js = [
		'js/seo_form.js'
	];
	public $css = [
		'css/seo_form.css'
	];
	public $depends = [
		'common\assets\JQueryUIAsset',
	];
}
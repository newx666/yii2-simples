<?php
namespace backend\components\widgets\image_selector;

use yii\widgets\InputWidget;

class ImageSelectorWidget extends InputWidget
{

	public function init()
	{
		parent::init();
	}

	public function run()
	{
		return $this->render('main', [
			'model' => $this->model,
			'attribute' => $this->attribute,
		]);
	}
}
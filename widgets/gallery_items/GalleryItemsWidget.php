<?php
/**
 * Created by PhpStorm.
 * Date: 03.12.15
 * Time: 0:17
 */

namespace backend\components\widgets\gallery_items;


use common\models\ar\Gallery;
use yii\widgets\InputWidget;

class GalleryItemsWidget extends InputWidget
{
	/**
	 * @var Gallery
	 */
	public $gallery;
	public $actions = [];
	public function run()
	{
		return $this->render('main', [
			'model' => $this->model,
			'attribute' => $this->attribute,
			'gallery' => $this->gallery,
			'actions' => $this->actions,
		]);
	}
}
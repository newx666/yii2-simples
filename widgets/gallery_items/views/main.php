<?php
/**
 * Created by PhpStorm.
 * Date: 03.12.15
 * Time: 0:22
 */
use backend\components\widgets\gallery_items\assets\GalleryItemsAsset;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $model \yii\base\Model */
/* @var $attribute string */
/* @var $gallery \common\models\ar\Gallery */
/* @var $actions [] */

/* @var $imageManager \common\components\ImageManager */
$imageManager = Yii::$app->imageManager;

GalleryItemsAsset::register($this);

$inputName = Html::getInputName($model, $attribute);
$inputValue = $model->$attribute;

$this->registerJs('window.imageManagerThumbUrl="' . \yii\helpers\Url::to(['image-manager/thumb']) . '";', $this::POS_BEGIN);
?>

<div class="gallery-items-wrapper">
	<span style="display: none;" class="serializeInput"><?= Html::activeHiddenInput($model, $attribute) ?></span>

	<div class="collapse-panel">
		<h3>Панель редактирования галлереи</h3>

		<div>
			<div class="multi-actions">
				<?= InputFile::widget([
					'name' => 'addingFiles',
					'template' => '<span style="display: none" class="adding-files">{input}</span>{button}',
					'buttonName' => '<i class="glyphicon glyphicon-plus"></i>',
					'buttonOptions' => [
						'class' => 'btn btn-success',
						'title' => 'Добавить файлы',
					],
					'multiple' => true,
					'filter' => 'image',
				]) ?>
				<button style="display: none;" class="delete btn btn-danger" title="Удалить отмеченные"><i
						class="glyphicon glyphicon-minus"></i></button>
			</div>

			<div class="image-items-list">
				<?php if ($gallery): ?>
					<?php foreach ($gallery->galleryItems as $galleryItem): ?>
						<div class="image-item" data-file="<?= $galleryItem->image ?>"
						     data-posit="<?= $galleryItem->position ?>">
							<div class="header">
			            <span class="control">
			                <input class="select" type="checkbox" title="Отметить">
				            <?php foreach ($actions as $action): ?>
					            <?= $action($galleryItem->id) ?>
				            <?php endforeach; ?>
			            </span>
							</div>
							<img src="<?= $imageManager->thumbUrl($galleryItem->image, 150, 150) ?>" alt="">
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php
/* @var $this \yii\web\View */
/* @var $model \yii\base\Model */
/* @var $attribute string */

use backend\components\widgets\image_selector\assets\ImageSelectorAsset;
use yii\helpers\Url;

//
$imageManagerThumbUrl = Url::to(['image-manager/thumb']);
$this->registerJs("window.imageSelectorParams = {thumbUrl: '$imageManagerThumbUrl'}", $this::POS_HEAD);
ImageSelectorAsset::register($this);
/**
 *
 */

/* @var $imageManager \common\components\ImageManager */
$imageManager = Yii::$app->imageManager;
?>

<?= \mihaildev\elfinder\InputFile::widget([
    'filter' => 'image',
    'model' => $model,
    'attribute' => $attribute,
    'template' => '<div class="image-selector">{button}<span class="input">{input}</span></div>',
    'buttonName' => '',
    'buttonTag' => 'a',
    'buttonOptions' => [
        'href' => 'javascript:void(0);'
    ]
]) ?>
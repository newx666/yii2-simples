<?php
/* @var $this \yii\web\View */
use backend\components\widgets\seo_form\assets\SeoFormAsset;
use yii\helpers\Json;
use yii\helpers\Url;

/* @var $form \yii\widgets\ActiveForm */
/* @var $seoModel \common\models\ar\Seo */
/* @var $label string */
$seoFormData = [];
SeoFormAsset::register($this);
$this->registerJs('window.seoFormData=' . Json::encode($seoFormData), $this::POS_BEGIN);
?>
	<div class="seo-form-wrapper">
		<div class="collapse-panel">
			<h3><?=$label?></h3>
			<div>
				<?=$form->field($seoModel, 'title')->textInput()?>
				<?=$form->field($seoModel, 'meta_description')->textarea()?>
				<?=$form->field($seoModel, 'meta_keywords')->textarea()?>
			</div>
		</div>
	</div>
<br><br>
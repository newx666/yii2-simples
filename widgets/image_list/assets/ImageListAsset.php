<?php
/**
 * Created by PhpStorm.
 * Date: 20.04.16
 * Time: 18:59
 */

namespace backend\components\widgets\image_list\assets;


use yii\web\AssetBundle;

class ImageListAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = __DIR__ . '/../static';
    }

    public $baseUrl = '@web';
    public $js = [
        'js/image_list.js'
    ];
    public $css = [
        'css/image_list.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'common\assets\JQueryUIAsset',
    ];
}
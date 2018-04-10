<?php
/**
 * Created by PhpStorm.
 * Date: 20.04.16
 * Time: 18:46
 */

namespace backend\components\widgets\image_list;


use yii\widgets\InputWidget;

class ImageListWidget extends InputWidget
{
    public $label;
    /**
     * Например /gallery-item/update?id=__id__
     * @var string
     */
    public $editImageActionTemplate;
    public function init()
    {
        if(!$this->label){
            $this->label = $this->model->getAttributeLabel($this->attribute);
        }
    }

    public function run()
    {
        return $this->render('main', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'label' => $this->label,
            'editImageActionTemplate' => $this->editImageActionTemplate,
        ]);
    }
}
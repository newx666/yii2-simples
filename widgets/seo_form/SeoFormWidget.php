<?php
/**
 * Created by PhpStorm.
 * Date: 15.12.15
 * Time: 1:39
 */

namespace backend\components\widgets\seo_form;


use yii\base\Widget;

class SeoFormWidget extends Widget
{
    public $form;
    public $seoModel;
    public $label = 'SEO';

    public function run()
    {
        return $this->render('main', [
            'form' => $this->form,
            'seoModel' => $this->seoModel,
            'label' => $this->label,
        ]);
    }
}
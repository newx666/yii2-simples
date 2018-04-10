<?php
/* @var $this \yii\web\View */
/* @var $editImageActionTemplate string */
use backend\components\widgets\image_list\assets\ImageListAsset;
use mihaildev\elfinder\InputFile;
use yii\helpers\Json;
use yii\helpers\Url;

/* @var $model \yii\base\Model */
/* @var $attribute string */
ImageListAsset::register($this);
$imageListThumbUrlTemplate = Url::to(['image-manager/thumb-redirect',
    'image' => '__image__',
    'width' => '__width__',
    'height' => '__height__',
]);
$this->registerJs('window.IMAGE_LIST_THUMB_REDIRECT_URL_TEMPLATE=' . Json::encode($imageListThumbUrlTemplate), $this::POS_BEGIN);
$this->registerJs('window.IMAGE_LIST_EDIT_ACTION_URL_TEMPLATE=' . Json::encode($editImageActionTemplate), $this::POS_BEGIN);
?>
<div class="image-list-wrapper">

    <div style="display: none" class="image-item-template">
        <div data-id="" class="image-item">
            <div class="header">
			            <span class="control">
			                <input class="select" type="checkbox" title="Отметить">
                            <div class="btn-group">
                                <a href="javascript:void(0)"
                                   class="btn btn-xs btn-success dropdown-toggle"
                                   data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false"
                                   title="Добавить"
                                >
                                    <i class="glyphicon glyphicon-plus"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="add-action add-before" href="javascript:void(0)">
                                            <i class="glyphicon glyphicon-collapse-down"></i> Перед
                                        </a>
                                    </li>
                                    <li>
                                        <a class="add-action add-after" href="javascript:void(0)">
                                            <i class="glyphicon glyphicon-collapse-up"></i> После
                                        </a>
                                    </li>
                                    <li>
                                        <a class="add-action add-replace" href="javascript:void(0)">
                                            <i class="glyphicon glyphicon-log-in"></i> Вместо
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="btn-group">
                                <a
                                    style="display: none"
                                    class="btn btn-default btn-xs edit-action"
                                    href="#"
                                    title="Редактировать"
                                >
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                            </div>
                            <div class="btn-group">
                                <a
                                    href="javascript:void(0)"
                                    class="btn btn-danger btn-xs add-action add-remove"
                                    title="Удалить"
                                >
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </div>
			            </span>
            </div>
            <a href="#" target="_blank" class="open-image">
                <img src="" width="150" height="150" alt="">
            </a>
        </div>
    </div>

    <?= \yii\helpers\Html::activeHiddenInput($model, $attribute, [
        'value' => Json::encode($model->$attribute),
        'class' => 'bind-value'
    ]) ?>
    <div class="collapse-panel">
        <h3><?= $model->getAttributeLabel($attribute) ?></h3>
        <div>
            <div class="multi-actions">
                <?= InputFile::widget([
                    'name' => 'adding-images',
                    'template' => '<span style="display: none" class="adding-files">{input}</span> {button}',
                    'buttonOptions' => [
                        'style' => 'display:none',
                        'class' => 'select-file-button'
                    ],
                    'multiple' => true,
//                'filter' => 'image',
                ]) ?>

                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="glyphicon glyphicon-plus"></i> Добавить <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="add-action add-begin" href="javascript:void(0)">
                                <i class="glyphicon glyphicon-collapse-down"></i> В начало
                            </a>
                        </li>
                        <li>
                            <a class="add-action add-end" href="javascript:void(0)">
                                <i class="glyphicon glyphicon-collapse-up"></i> В конец
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-primary check-action check-all">
                        <i class="glyphicon glyphicon-check"></i> Отметить все
                    </a>
                    <a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="check-action uncheck-all" href="javascript:void(0)">
                                <i class="glyphicon glyphicon-unchecked"></i> Отменить выделение
                            </a>
                        </li>
                        <li>
                            <a class="check-action check-inverse" href="javascript:void(0)">
                                <i class="glyphicon glyphicon-adjust"></i>
                                Инвертировать выделенное
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="glyphicon glyphicon-check"></i> С отмеченными <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="check-action action-delete" href="javascript:void(0)">
                                <i class="glyphicon glyphicon-trash"></i> Удалить
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="glyphicon glyphicon glyphicon-sort-by-attributes"></i> Сортировать <span
                            class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="check-action action-sort-filename-number" href="javascript:void(0)">
                                <i class="glyphicon glyphicon-sort-by-order"></i> По числовому имени файлов
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
            <br>
            <div class="image-items-list">
            </div>
        </div>
    </div>
</div>
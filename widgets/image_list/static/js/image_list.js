/**
 * Created on 20.04.16.
 */
"use strict";
var SELECT_TYPE_BEGIN = 0;
var SELECT_TYPE_END = 1;
var SELECT_TYPE_BEFORE = 2;
var SELECT_TYPE_AFTER = 3;
var SELECT_TYPE_REPLACE = 4;

var thumbUrlTpl = window.IMAGE_LIST_THUMB_REDIRECT_URL_TEMPLATE;
var editUrlTpl = window.IMAGE_LIST_EDIT_ACTION_URL_TEMPLATE;

$(function () {
    $('.image-list-wrapper').each(function () {
        var $this = $(this);

        $this.find('.collapse-panel').accordion({
            collapsible: true,
            //active: 1
        });

        var selectTypeContext = null;
        var selectType = SELECT_TYPE_END;

        var itemTemplate = $this.find('.image-item-template').html();

        var selectFileDialogOpen = function () {
            $this.find('.select-file-button').click();
        };

        var bindToDom = function () {
            var items = JSON.parse($this.find('input.bind-value').val());
            var domItems = $('<div/>');
            items.forEach(function (item) {
                var htmlItem = $(itemTemplate);
                htmlItem.attr('data-id', item.id);
                htmlItem.find('a.open-image').attr('href', item.image);
                var imageWidth = htmlItem.find('a.open-image img').attr('width');
                var imageHeight = htmlItem.find('a.open-image img').attr('height');
                var thumbUrl = thumbUrlTpl
                    .replace('__image__', item.image)
                    .replace('__width__', imageWidth)
                    .replace('__height__', imageHeight);
                htmlItem.find('a.open-image img').attr('src', thumbUrl);
                if(item.id && editUrlTpl){
                    var editUrl = editUrlTpl.replace('__ID__', item.id);
                    htmlItem.find('a.edit-action').attr('href', editUrl).show();
                }
                domItems.append(htmlItem);
            });
            $this.find('.image-items-list').html(domItems.html());
            $this.find('.collapse-panel').accordion('refresh');
            bindToInput();
        };

        var bindToInput = function () {
            var position = 0;
            var items = [];
            $this.find('.image-items-list .image-item').each(function () {
                var itemDom = $(this);
                position++;
                items.push({
                    id: itemDom.attr('data-id') || null,
                    position: position,
                    image: itemDom.find('a.open-image').attr('href')
                });
            });
            $this.find('input.bind-value').val(JSON.stringify(items));
            console.log(items);
        };

        $this.find('.image-items-list').sortable({
            items: '> .image-item',
            handle: '.header',
            stop: function () {
                bindToInput();
            }
        });

        $(document).on('change.image-list', '.image-items-list .image-item .header .control input.select', function (e) {
            if ($(e.target).closest('.image-list-wrapper').get(0) === $this.get(0)) {
                if (this.checked) {
                    $(this).closest('.header').addClass('checked');
                } else {
                    $(this).closest('.header').removeClass('checked');
                }
            }
        });

        $(document).on('click.image-list-add-action', '.add-action', function (e) {
            var elm = $(this);
            if (elm.closest('.image-list-wrapper').get(0) === $this.get(0)) {
                if (elm.is('.add-before') || elm.is('.add-after') || elm.is('.add-replace')) {
                    var item = elm.closest('.image-item').get(0);
                    var i = -1;
                    var isFind = false;
                    $this.find('.image-items-list .image-item').each(function () {
                        if (isFind) {
                            return;
                        }
                        i++;
                        if (this === item) {
                            selectTypeContext = i;
                            isFind = true;
                        }
                    });
                }
                if (elm.is('.add-remove')) {
                    if (confirm('Вы уверены что хотите удалить этот элемент?')) {
                        elm.closest('.image-item').remove();
                        bindToInput();
                    }
                } else if (elm.is('.add-begin')) {
                    selectType = SELECT_TYPE_BEGIN;
                    selectFileDialogOpen();
                } else if (elm.is('.add-end')) {
                    selectType = SELECT_TYPE_END;
                    selectFileDialogOpen();
                } else if (elm.is('.add-before')) {
                    selectType = SELECT_TYPE_BEFORE;
                    selectFileDialogOpen();
                } else if (elm.is('.add-after')) {
                    selectType = SELECT_TYPE_AFTER;
                    selectFileDialogOpen();
                } else if (elm.is('.add-replace')) {
                    selectType = SELECT_TYPE_REPLACE;
                    selectFileDialogOpen();
                }
            }
        });

        $this.find('.multi-actions .check-action').on('click', function () {
            if ($(this).is('.check-all')) {
                $this.find('.image-items-list .image-item .header .control input.select').each(function () {
                    this.checked = true;
                    $(this).trigger('change');
                });
            } else if ($(this).is('.uncheck-all')) {
                $this.find('.image-items-list .image-item .header .control input.select').each(function () {
                    this.checked = false;
                    $(this).trigger('change');
                });
            } else if ($(this).is('.check-inverse')) {
                $this.find('.image-items-list .image-item .header .control input.select').each(function () {
                    this.checked = !this.checked;
                    $(this).trigger('change');
                });
            } else if ($(this).is('.action-delete')) {
                if (confirm('Вы уверены что хотите удалить отмеченные элементы?')) {
                    $this
                        .find('.image-items-list .image-item .header .control input.select:checked')
                        .closest('.image-item')
                        .remove();
                    bindToInput();
                }
            }else if($(this).is('.action-sort-filename-number')){
                var items = JSON.parse($this.find('input.bind-value').val());
                items = items.sort(function (a, b) {
                    var r = /([^\/]+)\.\w+$/;
                    a = parseFloat(r.exec(a.image)[1]);
                    b = parseFloat(r.exec(b.image)[1]);
                    console.log(a,b);
                    return a-b;
                });
                $this.find('input.bind-value').val(JSON.stringify(items));
                bindToDom();
            }
            //return false;
        });


        $this.find('[name=adding-images]').on('change', function () {
            var newItems = $this.find('[name=adding-images]').val().split(',').map(function (item) {
                return item.trim();
            }).filter(function (item) {
                return !!item;
            }).map(function (item) {
                return {
                    id: null,
                    position: null,
                    image: item
                };
            });
            $this.find('[name=adding-images]').val('');
            var items = JSON.parse($this.find('input.bind-value').val());
            switch(selectType){
                case SELECT_TYPE_BEGIN:
                    items = newItems.concat(items);
                    break;
                case SELECT_TYPE_END:
                    items = items.concat(newItems);
                    break;
                case SELECT_TYPE_BEFORE:
                    var args = [selectTypeContext, 0].concat(newItems);
                    items.splice.apply(items, args);
                    break;
                case SELECT_TYPE_AFTER:
                    var args = [selectTypeContext+1, 0].concat(newItems);
                    items.splice.apply(items, args);
                    break;
                case SELECT_TYPE_REPLACE:
                    var firstItem = newItems.shift();
                    items[selectTypeContext].image = firstItem.image;
                    var args = [selectTypeContext+1, 0].concat(newItems);
                    items.splice.apply(items, args);
                    break;
            }
            $this.find('input.bind-value').val(JSON.stringify(items));
            bindToDom();
        });

        $('.gallery-items-wrapper .image-items-list').sortable({
            items: '> .image-item',
            handle: '.header'
        });

        bindToDom();
    });

});
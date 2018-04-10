/**
 * Created on 03.12.15.
 */
"use strict";
(function ($) {
    var templates = {
        imageItem: '\
    <div class="image-item">\
        <div class="header">\
            <span class="control">\
                <input class="select" type="checkbox" title="Отметить">\
            </span>\
        </div>\
        <img src="" alt="">\
    </div>'
    };

    $(function () {
        $('.gallery-items-wrapper .collapse-panel').accordion({
            collapsible: true,
            active: 2
        });

        var isFirstInit = true;

        function init() {

            var updatePosit = function () {
                var posit = 0;
                $('.image-item').each(function () {
                    posit++;
                    $(this).attr('data-posit', posit);
                });
            };

            $('.gallery-items-wrapper .image-items-list').sortable({
                items: '> .image-item',
                handle: '.header'
            });

            $(".gallery-items-wrapper .image-items-list").sortable({
                stop: function (event, ui) {
                    init();
                }
            });

            if(!isFirstInit){
                $('.gallery-items-wrapper .collapse-panel').accordion('refresh');
            }

            $('.image-item .header .control .select').off('change.select-item').on('change.select-item', function () {
                if ($('.image-item .header .control .select:checked').length) {
                    $('.multi-actions button.delete').show();
                } else {
                    $('.multi-actions button.delete').hide();
                }
            });
            updatePosit();

            var serializeData = [];
            $('.image-item').each(function () {
                serializeData.push({
                    file: $(this).attr('data-file'),
                    posit: parseInt($(this).attr('data-posit'))
                });
            });
            $('.serializeInput input').val(JSON.stringify(serializeData));
            isFirstInit = false;
        }

        $( ".gallery-items-wrapper .collapse-panel" ).accordion({
            activate: function( event, ui ) {init()}
        });

        var addImageItem = function (img) {
            $.get(window.imageManagerThumbUrl, {
                image: img,
                width: 150,
                height: 150
            }).then(function (thumbUrl) {
                var item = $(templates.imageItem);
                item.attr('data-file', img);
                item.attr('data-posit', 0);
                item.find('img').attr('src', thumbUrl);
                item.appendTo('.image-items-list');
                init();
            });
        };

        $('.adding-files input').on('change', function () {
            var fileChanges = $(this).val();
            if (fileChanges) {
                fileChanges.split(', ').forEach(function (file) {
                    if (!!file.trim()) {
                        addImageItem(file);
                    }
                });
            }
            $(this).val('');
        });

        $('.multi-actions button.delete').on('click', function () {
            if (confirm('Вы уверены что хотите удалить выбранные элементы?')) {
                $('.image-item .header .control .select:checked').each(function () {
                    $(this).closest('.image-item').remove();
                });
                $('.multi-actions button.delete').hide();
                init();
            }
            return false;
        });

        init();
    });
})(jQuery);
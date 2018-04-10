"use strict";

(function ($) {
    $(function () {
        var imageSelectorParams = window.imageSelectorParams;

        var updateImage = function (selectImageBlock) {
            var img = selectImageBlock.find('span.input input').val();
            if(img){
                $.get(imageSelectorParams.thumbUrl, {
                    image: img,
                    width: 200,
                    height: 200
                }).then(function (thumbPath) {
                    selectImageBlock.css({
                        'background-image': 'url("'+thumbPath+'")'
                    });
                }, function (err) {
                    alert('Ошибка');
                    console.error(err);
                });
            }
        };

        $('.image-selector').each(function () {
            var $this = $(this);
            updateImage($this);
            $this.find('span.input input').on('change.select-image', function () {
                var $this = $(this);
                updateImage($this.closest('.image-selector'));
            });
        });
    });
})(jQuery);
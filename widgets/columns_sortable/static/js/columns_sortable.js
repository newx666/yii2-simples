/**
 * Created on 09.12.15.
 */
"use strict";

$(function () {

    var widgetParams = window.sortWidgetParams;

    if(!$('[data-sort-posit]:first').length){
        $('#to-resort').remove();
    }

    $('[data-sort-posit]:first').closest('tbody').sortable({
        items: '> tr',
        handle: '[data-sort-handle]'
    });

    $('#to-resort').on('click', function () {
        var posit = 0;
        var res = [];
        $('[data-sort-posit]').each(function () {
            posit++;
            var id= parseInt($(this).attr('data-sort-id'));
            res.push({
                id: id,
                posit: posit
            });
        });
        $.post(widgetParams.actionUrl, {
            modelClass: widgetParams.modelClass,
            modelPositAttribute: widgetParams.attribute,
            modelIdAttribute: widgetParams.idModelAttribute,
            sortData: res

        }).then(function (d) {
            console.log('success');
            console.log(d);
            window.location.reload();
        }, function (err) {
            alert('Ошибка сортировк');
            console.error(err);
        });
        console.log(res);
        console.log(widgetParams);
    });
});
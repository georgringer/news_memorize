$(document).ready(function () {
    var allElements = $('.news-memorize');
    if ($(allElements).length) {
        $.ajax({
            url: '/?eID=memorize',
            data: {
                'action': 'get'
            },
            type: 'GET',
            success: function (result) {
                var memorizedNewsList = $.parseJSON(result);
                for (var i = 0; i < memorizedNewsList.length; i++) {
                    var container = $('.news-memorize[data-newsid="' + memorizedNewsList[i] + '"]');
                    $(container).addClass('active');
                    $(container).find('.add').hide();
                    $(container).find('.remove').show();
                }


            }
        });

        $(allElements).click(function (i, el) {
            var isInList = $(this).hasClass('active');
            var currentElement = $(this);
            $.ajax({
                url: '/?eID=memorize',
                data: {
                    'action': isInList ? 'remove' : 'add',
                    'hash': $(this).data('hash'),
                    'news': $(this).data('newsid')
                },
                type: 'GET',
                success: function (result) {
                    if (isInList) {
                        $(currentElement).removeClass('active');
                        $(currentElement).find('.add').show();
                        $(currentElement).find('.remove').hide();
                    } else {
                        $(currentElement).addClass('active');
                        $(currentElement).find('.add').hide();
                        $(currentElement).find('.remove').show();
                    }
                }
            });
        })
    }


});

// CLONE NAVBAR TO MOBILE NAVBAR
$('.navbar.navbar-default .container > ul').clone().appendTo('.navbar.navbar-mobile');

$('body').on('click', function(event) {

    if ($(event.target).attr('ajax') == 'close') {
        $(event.target).closest('[ajax-selector="alert"]').remove();
        $(event.target).closest('[ajax-selector="window"]').removeClass('window-active');
    }

    if ($(event.target).parents('[ajax-selector^="navbar"]').length == 0) {
        $('.navbar-opened').removeClass('navbar-opened');
    }
});


// ALLOW FONT AWESOME IN PSEUDO ELEMENTS
window.FontAwesomeConfig = {
    searchPseudoElements: true
}

// SHOW PAGE WHEN IS LOADED
$(document).ready(function() {
    $('body').css('display', 'flex');
});

// TAB
$('.' + $('.tab-button.default').attr('id')).show();

$('.tab-button').on('click', function(event) {
    $('.tab-button').removeClass('active');

    $('.tabcontent').hide();
    $(event.target).addClass('active');
    $('.' + event.target.id + '.tabcontent').css('display', 'block');
});

// MOBILE DROPDOWN
$('[ajax="collapse"]').on('click', function() {

    var $navbarMobile = $('[ajax-selector="navbar navbar-side"]');
    $navbarMobile.toggleClass('navbar-opened', !$navbarMobile.hasClass('navbar-opened'));
});

function scripts($element) {
    if ($element.is(':checked') && $element.attr('value') == 1) {
        $('[disable-on="'+$element.attr('name')+'"]').addClass('field-row-disabled');
        $('[enable-on="'+$element.attr('name')+'"]').removeClass('field-row-disabled');
        $('[show-on="'+$element.attr('name')+'"]').show();
        $('[hide-on="'+$element.attr('name')+'"]').hide();
    } else {
        $('[disable-on="'+$element.attr('name')+'"]').removeClass('field-row-disabled');
        $('[enable-on="'+$element.attr('name')+'"]').addClass('field-row-disabled');
        $('[show-on="'+$element.attr('name')+'"]').hide();
        $('[hide-on="'+$element.attr('name')+'"]').show();
    } 
}

$('input.script[type="radio"], input.script[type="checkbox"]').on('click', function() {
    scripts($(this));
});

$('input.script').each(function() {
    if ($(this).is(':checked') || $(this).attr('type') == 'checkbox') {
        scripts($(this));
    }
});

$('[ajax-selector="dropdown"]').on('click', function() {

    if ($(this).hasClass('navbar-dropdown-opened')) {

        $(this).removeClass('navbar-dropdown-opened');
        $(this).find('[ajax-selector="arrow-left"]').show();
        $(this).find('[ajax-selector="arrow-down"]').hide();


    } else {
        $(this).addClass('navbar-dropdown-opened');
        $(this).find('[ajax-selector="arrow-left"]').hide();
        $(this).find('[ajax-selector="arrow-down"]').show();
    }
});

$('[ajax-selector="list"]').each(function () {

    $rowBody = $(this).find('[ajax-selector="list-body"]').children();
    $rowBody.first().children('[ajax-selector="list-row-inner"]').find('[ajax="up"]').remove();
    $rowBody.last().children('[ajax-selector="list-row-inner"]').find('[ajax="down"]').remove();
    
    $rowBody.each(function () {
        $body = $(this).find('[ajax-selector^="list-body"]').children();
        $body.first().find('[ajax="up"]').remove();
        $body.last().find('[ajax="down"]').remove();
    });

});

$('[ajax-selector="title"]').after($('[ajax-selector="title"]').clone().addClass('disabled'));
$('[ajax="title"]').on({
    mouseenter: function() {
        
        if ($('[ajax-selector="title"]:not(.disabled)').length) {

            var $title = $('[ajax-selector="title"]:not(.disabled)');

        } else {
            var $title = $('[ajax-selector="title"]:not(.disabled)').clone();
            $('[ajax-selector="title"]').after($title);
        }

        $title.addClass('active');
        $title.removeClass('disabled');
        $title.find('[ajax-selector="text"]').text($.trim($(this).data('title')));
        $title.css({'left': $(this).offset().left, 'top': $(this).offset().top - $(this).height() * 2});

        $('[ajax-selector="title"]').removeClass('disabled');
    },
    mouseleave: function() {
        $('.active[ajax-selector="title"]').removeClass('active').addClass('disabled');
        setTimeout(function() {
            $('.disabled[ajax-selector="title"]').css({'left': 0, 'top': 0});
        }, 500);
    }
});














$.cAjax('up', {
    ajax: {
        url: '/admin/ajax/process/',
        method: 'get',
        context: {}
    },
    success: function (settings, $element) {

        $listMedium = $element.children('[ajax-selector="list-row-inner"]').children('[ajax-selector="list-row-medium"]');
        $listPrevMedium = $element.prev('[ajax-selector="list-row"]').children('[ajax-selector="list-row-inner"]').children('[ajax-selector="list-row-medium"]');

        if (!$element.prev('[ajax-selector="list-row"]').prev('[ajax-selector="list-row"]').length) {
            $listMedium.find('[ajax="up"]').remove();
            $listPrevMedium.find('[ajax="down"]').before('<a class="button button-up" ajax="up"><i class="fas fa-caret-up"></i></a>');
        }

        if (!$element.next().length) {
            $listMedium.prepend('<a class="button button-down" ajax="down"><i class="fas fa-caret-down"></i></a>');
            $listPrevMedium.find('[ajax="down"]').remove();
        }

        $element.prev().insertAfter($element);
    }
});

$.cAjax('down', {
    ajax: {
        url: '/admin/ajax/process/',
        method: 'get',
        context: {}
    },
    success: function (settings, $element) {

        $listMedium = $element.children('[ajax-selector="list-row-inner"]').children('[ajax-selector="list-row-medium"]');
        $listNextMedium = $element.next().children('[ajax-selector="list-row-inner"]').children('[ajax-selector="list-row-medium"]');

        if (!$element.next().next().length) {
            $listMedium.find('[ajax="down"]').remove();
            $listNextMedium.find('[ajax="up"]').before('<a class="button button-down" ajax="down"><i class="fas fa-caret-down"></i></a>');
        }
        
        if (!$element.prev('[ajax-selector="list-row"]').length) {
            $listMedium.prepend('<a class="button button-up" ajax="up"><i class="fas fa-caret-up"></i></a>');
            $listNextMedium.find('[ajax="up"]').remove();
        }

        $element.next().insertBefore($element);
    }
});

$.cAjax('back', {
    ajax: {
        url: '/admin/ajax/process/',
        method: 'get',
        context: {}
    },
    success: function() {}
});
$.cAjax('delete', {
    refresh: true,
    ajax: {
        url: '/admin/ajax/process/',
        method: 'get',
        context: {}
    },
    window: {
        url: '/admin/ajax/language/',
        context: {}
    },
    success: function() {}
});
$.cAjax('promote', {
    ajax: {
        url: '/admin/ajax/process/',
        method: 'get',
        context: {}
    },
    window: {
        url: '/admin/ajax/language/',
        context: {}
    },
    success: function() {}
});

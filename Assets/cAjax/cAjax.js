(function($) {

    // WINDOW
    var $window = $('[ajax-selector="window"]');

    // LOADING ICON
    var $loading = $('[ajax-selector="loading"]');

    // WINDOW ALERT
    var $alert = $('[ajax-selector="window-alert"]');

    jQuery.cAjax = function (process, settings) {

        $('body').on('click', '[ajax="' + process + '"]', function (event) {

            event.preventDefault();
            event.stopImmediatePropagation()

            $loading.show();

            var $element = '';

            // BUTTON
            var $button = $element = $(this);

            if (!$element.data('id')) {
                $.each(['block', 'field', 'list-row'], function (key, selector) {
                    if ($button.closest('[ajax-selector="'+selector+'"]').length) {
                        $element = $button.closest('[ajax-selector="'+selector+'"]').first();
                        return false;
                    }
                });
            }

            // ELEMENT ID
            settings.id = $element.attr('data-id');
            settings.type = $element.attr('data-type');
            settings.process = $element.attr('data-type') ? settings.type + '/' + process.substr(0,1).toUpperCase()+process.substr(1) : null;
            if (settings.ajax){

                if (settings.ajax.method == 'post') {
                    delete settings.ajax.context.id;
                    delete settings.ajax.context.method;
                    delete settings.ajax.context.process;

                } else {
                    settings.ajax.context.id = settings.id;
                    settings.ajax.context.method = settings.ajax.method;

                    if (settings.process) {
                        settings.ajax.context.process = settings.process
                    }
                }
            }

            // ONLOAD FUNCTION
            if (settings.onload) {
                settings.onload.call($button, settings, $element);
            }
            
            methods = {
                ajax: {
                    // GET REQUEST
                    get: function () {

                        $.get(settings.ajax.url, settings.ajax.context, function (data) {
                            methods.finish(data)
                        });
                    },

                    // POST REQUEST
                    post: function () {

                        // CALL PROCESS
                        $.post(settings.ajax.url + '?id=' + settings.id + (settings.process ? '&process=' + settings.process : '') + '&method=post', settings.ajax.context, function (data) {
                            methods.finish(data)
                        });
                    }
                },

                finish: function (data) {

                    // HIDE LOADING ICON
                    $loading.hide();

                    // PARSE RETURN STATUS
                    settings.data = $.parseJSON(data);

                    // IF EVERYTHING OK
                    if (settings.data.status != 'ok') {

                        if (settings.data.status == 'error') {
                            $alert.removeClass('window-hide').addClass('window-active').removeClass('window-alert-success');
                            $alert.find('[ajax-selector="window-alert-body"]').text(settings.data.error);
                            setTimeout(function() {
                                $alert.addClass('window-hide').removeClass('window-active');
                            }, 1500);
                        }

                        return false;
                    }

                    // REDIRECT USER
                    if (settings.data.redirect) {
                        window.location.href = settings.data.redirect;
                        return true;
                    }

                    if (settings.data.message) {
                        $alert.removeClass('window-hide').addClass('window-active').addClass('window-alert-success');
                        $alert.find('[ajax-selector="window-alert-body"]').text(settings.data.message);
                        setTimeout(function() {
                            $alert.addClass('window-hide').removeClass('window-active');
                        }, 1500);
                    }

                    // REFRESH PAGE
                    if (settings.refresh == true) {
                        location.reload();
                    }

                    // CALL CALLBACK FUNCTION
                    settings.success.call($button, settings, $element);

                    // HIDE WINDOW
                    $window.removeClass('window-active');

                }
            }

            // USE WINDOW
            if (settings.window) {

                settings.window.context.id = settings.id;
                settings.window.context.process = settings.process;

                $.get(settings.window.url, settings.window.context, function (data) {
                    settings.data = $.parseJSON(data);

                    $loading.hide();
                    
                    if (settings.data.status != 'ok') {
                        return false;
                    }

                    // SET WINDOW
                    $window.addClass('window-active');
                    $window.find('[ajax-selector="window-title"]').text(settings.data.windowTitle);
                    console.log(settings.data.windowContent);
                    $window.find('[ajax-selector="window-body"]').html(settings.data.windowContent);

                    if (settings.data.windowSubmit) {
                        $window.find('[ajax-selector="window-bottom"]').show();
                        $window.find('[ajax-selector="window-submit"]').text(settings.data.windowSubmit);
                        $window.find('[ajax-selector="window-cancel"]').text(settings.data.windowClose);
                    } else {
                        $window.find('[ajax-selector="window-bottom"]').hide();
                    }

                    if (settings.window.onload) {
                        settings.window.onload.call($window, settings);
                    }
                });
            }

            if (settings.ajax) {

                if (settings.window) {

                    $('[ajax="confirm"]').on('click', function (event) {

                        event.preventDefault();

                        // SHOW LOADING ICON
                        $loading.show();

                        if (settings.window.submit) {
                            settings.window.submit.call($window, settings);
                        }

                        if (settings.ajax.method == 'post') {
                            methods.ajax.post();
                        } else {
                            methods.ajax.get();
                        }
                    });

                    $('body').on('click', function(event) {

                        if (!$(event.target).parents('[ajax-selector="window"]').length) {
                            $('[ajax="confirm"]').off('click');
                            $window.removeClass('window-active');
                        }
                    
                        if ($(event.target).attr('ajax') == 'window-close') {
                            $('[ajax="confirm"]').off('click');
                            $window.removeClass('window-active');
                        }
                    });

                } else {

                    if (settings.ajax.method == 'post') {
                        methods.ajax.post();
                    } else {
                        methods.ajax.get();
                    }
                }
            }
        });
    };
})(jQuery);
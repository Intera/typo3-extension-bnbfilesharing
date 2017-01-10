define(['jquery', 'js-cookie', 'jquery-ui/widget'], function($, cookie) {

    $.widget('bnbfilesharing.txBnbfilesharingWidgetFilelist', {

        _lightboxInitialized: false,

        _initializeAccordeonState: function() {
            this.element.find('.panel').each(function() {
                var panel = $(this);
                var panelId = panel.attr('id');

                var showDiv = cookie.get(panelId);
                if (!showDiv) {
                    return;
                }

                var collapseTrigger = panel.find('> .panel-heading .tx-bnbfilesharing-collapse-trigger');
                collapseTrigger.removeClass('collapsed');
                collapseTrigger.attr('aria-expanded', 'true');

                var collapsible = panel.find('> .panel-collapse');
                collapsible.addClass('in');
                collapsible.attr('aria-expanded', 'true');

            });

            // When the div is shown, save a cookie with a value of 'true'.
            this.element.find('.panel').on('shown.bs.collapse', function() {
                cookie.set($(this).attr('id'), true);
            });

            // When the div is collapsed, remove the cookie.
            this.element.find('.panel').on('hidden.bs.collapse', function() {
                cookie.remove($(this).attr('id'));
            });
        },

        _create: function() {
            this._initializeAccordeonState();
        }
    });
});

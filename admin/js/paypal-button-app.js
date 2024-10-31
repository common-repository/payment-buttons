(function ($) {
    'use strict';
    $('.ppb-modal').on('shown', function (e) {
        $(this).find(':input:text:enabled:first').focus();
    });
    $(document).on('click', '[data-modal-save="true"]', function (e) {
        var data = {},
                modal = $(this).parents('.ppb-modal').first(),
                example = modal.closest('.paypale-payment-button-example'),
                code = example.find('textarea'),
                tryit = example.find('.tryit'),
                inputs = modal.find('.ppb-modal-body :input'),
                requiredInputs = modal.find('[required="required"]'),
                input, merchant, el, len, i, key, button;
        for (i = 0, len = requiredInputs.length; i < len; i++) {
            var requiredInput = $(requiredInputs[i]),
                    controlGroup = requiredInput.parents('.ppb-control-group').first();
            if (requiredInput.val() === '') {
                controlGroup.addClass('ppb-error');
                requiredInput.focus();
                return;
            } else {
                controlGroup.removeClass('ppb-error');
            }
        }
        for (i = 0, len = inputs.length; i < len; i++) {
            input = $(inputs[i]);
            if (input.is(':checkbox')) {
                if (input.is(':checked')) {
                    data[input.attr('name')] = {
                        value: input.val()
                    };
                }
            } else {
                data[input.attr('name')] = {
                    value: input.val()
                };
            }
        }
        el = document.createElement('script');
        el.setAttribute('async', 'async');
        if (data.button && data.button.value === 'cart') {
            el.src = paypal_payment_buttons_js.paypal_button_min_js + '?merchant=' + data.business.value;
        } else {
            el.src = paypal_payment_buttons_js.paypal_button_min_js + '?merchant=' + data.business.value;
        }
        for (key in data) {
            if (key !== 'business' && data[key].value !== '') {
                el.setAttribute('data-' + key, data[key].value);
            }
        }
        code.text(el.outerHTML.replace(/data-/g, "\n    data-").replace("></" + "script>", "\n></" + "script>"));
        button = PAYPAL.apps.ButtonFactory.create(data.business.value, data, data.button.value);
        button = $(button);
        button.css('display', 'none');
        tryit.empty();
        tryit.append(button);
        tryit.animate({
            height: (button.height() || 130) * 2
        }, 300, function () {
            button.fadeTo(300, 1);
        });
        modal.modal('hide');
    });
}(jQuery));
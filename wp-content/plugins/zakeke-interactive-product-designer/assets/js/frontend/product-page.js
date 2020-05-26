(function () {
    'use strict';

    var zakekeProductPage = function() {
        var cartAll = document.querySelectorAll('form.cart, #wholesale_form');
        cartAll.forEach(function (cart) {
            var cartSubmit = cart.querySelector('button[type=submit]');
            var zakekeInput = cart.querySelector('input[name=zakeke_design]');
            var customizeElement = cart.querySelector('.zakeke-customize-button');

            if (customizeElement) {
                customizeElement.addEventListener('click', function (e) {
                    e.preventDefault();

                    if (!cartSubmit.classList.contains('disabled')) {
                        zakekeInput.value = 'new';

                        cartSubmit.addEventListener('click', function (e) {
                            e.stopPropagation();
                        });
                    }

                    cartSubmit.click();
                });
            } else if (cartSubmit) {
                cartSubmit.addEventListener('click', function (e) {
                    if (cartSubmit.classList.contains('disabled')) {
                        return;
                    }

                    cart.onsubmit = function (e) { e.stopPropagation(); };

                    e.stopPropagation();
                });
            }

            cart.addEventListener('submit', function () {
                var addVariationToCartInput = cart.querySelector('input[name=add-variations-to-cart]');
                if (!addVariationToCartInput || !zakekeInput || zakekeInput.value !== 'new') {
                    return;
                }

                addVariationToCartInput.name = 'zakeke_tmp_prefix_add-variations-to-cart';
            });
        });
    };

    document.addEventListener('DOMContentLoaded', zakekeProductPage);
})();

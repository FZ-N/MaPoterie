function zakekeDesigner(config) {
    var productDataCache = {},
        pendingProductDataRequests = [],
        container = document.getElementById('zakeke-container'),
        iframe = container.querySelector('iframe'),
        updatedParams = function (color, zakekeOptions) {
            if (color == null) {
                throw new Error('color param is null');
            }

            var params = jQuery.extend({}, config.params),
                colorObj = JSON.parse(color);

            colorObj.forEach(function (val) {
                params['attribute_' + val.Id] = val.Value.Id;
            });

            if (zakekeOptions != null) {
                params = jQuery.extend(params, zakekeOptions);
            }

            return params;
        },
        emitProductDataEvent = function (productData) {
            iframe.contentWindow.postMessage({
                data: productData,
                zakekeMessageType: 1
            }, '*');
        },
        productData = function (color, zakekeOptions) {
            var params = updatedParams(color, zakekeOptions),
                queryString = jQuery.param(params),
                cached = productDataCache[queryString];

            if (cached !== undefined) {
                emitProductDataEvent(cached);
                return;
            }

            if (pendingProductDataRequests.indexOf(queryString) !== -1) {
                return;
            }

            pendingProductDataRequests.push(queryString);

            jQuery.ajax({
                url: wc_cart_fragments_params.wc_ajax_url.toString().replace('%%endpoint%%', 'zakeke_get_price'),
                type: 'POST',
                data: params
            })
                .done(function (product) {
                    if (typeof product === 'string' || product instanceof String) {
                        product = JSON.parse(product.trim());
                    }

                    var productData = {
                        color: color,
                        isOutOfStock: !(product.is_purchasable && product.is_in_stock),
                        finalPrice: product.price_including_tax
                    };
                    productDataCache[queryString] = productData;
                    emitProductDataEvent(productData);
                })
                .fail(function (request, status, error) {
                    console.log(request + ' ' + status + ' ' + error);
                    var productData = {
                        color: color,
                        isOutOfStock: true
                    };
                    productDataCache[queryString] = productData;
                    emitProductDataEvent(productData);
                })
                .always(function () {
                    var index = pendingProductDataRequests.indexOf(queryString);
                    if (index !== -1) {
                        pendingProductDataRequests.splice(index, 1);
                    }
                });
        },
        createCartSubInput = function (form, value, key, prevKey) {
            if (value instanceof String || typeof(value) !== 'object') {
                createCartInput(form, prevKey ? prevKey + '[' + key + ']' : key, value);
            } else {
                Object.keys(value).forEach(function (subKey) {
                    createCartSubInput(form, value[subKey], subKey, prevKey ? prevKey + '[' + key + ']' : key);
                });
            }
        },
        createCartInput = function (form, key, value) {
            var input = document.createElement('INPUT');
            input.type = 'hidden';
            input.name = key.replace('zakeke_tmp_prefix_', '');
            input.value = value.toString().replace(/\\/g, '');
            form.appendChild(input);
        },
        addToCart = function (color, design, model) {
            var zakekeOptions = {};
            zakekeOptions['zakeke_design'] = design;
            zakekeOptions['zakeke_model'] = model;
            var params = updatedParams(color, zakekeOptions),
                form = document.getElementById('zakeke-addtocart');

            form.method = 'POST';

            delete params['variation_id'];
            Object.keys(params).filter(function (x) {
                return params[x] != null;
            }).forEach(function (key) {
                createCartSubInput(form, params[key], key);
            });
            jQuery(form).submit();
        };

    window.addEventListener('message', function (event) {
        if (event.origin !== config.zakekeUrl) {
            return;
        }

        if (event.data.zakekeMessageType === 0) {
            addToCart(event.data.colorId, event.data.designId, event.data.modelId);
        } else if (event.data.zakekeMessageType === 1) {
            var zakekeOptions = {};
            if (event.data.design.price !== undefined) {
                zakekeOptions['zakeke-price'] = event.data.design.price;
            }
            if (event.data.design.percentPrice !== undefined) {
                zakekeOptions['zakeke-percent-price'] = event.data.design.percentPrice;
            }
            productData(event.data.design.color, zakekeOptions);
        }
    }, false);

    if (window.matchMedia('(min-width: 769px)').matches) {
        iframe.src = config.customizerLargeUrl;
    } else {
        iframe.src = config.customizerSmallUrl;
        window.addEventListener('resize', function () {
            iframe.style.minHeight = window.innerHeight + 'px';
            document.body.style.overflow = 'hidden';
        });
    }

}

document.addEventListener('DOMContentLoaded', function () {
    zakekeDesigner(window.zakekeDesignerConfig);
});
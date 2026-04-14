define(['jquery'], function ($) {
    'use strict';

    var maxItems = 10;

    return function (widget) {
        $.widget('mage.recentlyViewedProducts', widget, {
            _create: function () {
                this._super();

                var products = JSON.parse(window.localStorage.getItem(this.options.localStorageKey));

                if (products && products.sku && products.sku.length > maxItems) {
                    products.sku = products.sku.slice(0, maxItems);
                    products.html = products.html.slice(0, maxItems);
                    window.localStorage.setItem(this.options.localStorageKey, JSON.stringify(products));
                }
            }
        });

        return $.mage.recentlyViewedProducts;
    };
});

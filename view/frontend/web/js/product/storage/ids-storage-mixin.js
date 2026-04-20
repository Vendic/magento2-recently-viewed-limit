define(['underscore'], function (_) {
    'use strict';

    function getMaxItems() {
        return window.recentlyViewedStorageLimit || 10;
    }

    function trimToMax(data) {
        var maxItems = getMaxItems(),
            keys, sorted;

        if (!_.isObject(data) || _.isEmpty(data)) {
            return data;
        }

        keys = _.keys(data);

        if (keys.length <= maxItems) {
            return data;
        }

        sorted = keys.sort(function (a, b) {
            return (data[b] && data[b].added_at || 0) - (data[a] && data[a].added_at || 0);
        });

        return _.pick(data, sorted.slice(0, maxItems));
    }

    return function (idsStorage) {
        var originalHandler = idsStorage.internalDataHandler;

        idsStorage.internalDataHandler = function (data) {
            originalHandler.call(this, trimToMax(data));
        };

        idsStorage.cachesDataFromLocalStorage = function () {
            var data = this.getDataFromLocalStorage(),
                trimmed = trimToMax(data);

            if (_.keys(data).length !== _.keys(trimmed).length) {
                window.localStorage.setItem(this.namespace, JSON.stringify(trimmed));
            }

            this.data(trimmed);
            return this;
        };

        return idsStorage;
    };
});

var config = {
    config: {
        mixins: {
            'Magento_Reports/js/recently-viewed': {
                'Vendic_RecentlyViewedLimit/js/recently-viewed-mixin': true
            },
            'Magento_Catalog/js/product/storage/ids-storage': {
                'Vendic_RecentlyViewedLimit/js/product/storage/ids-storage-mixin': true
            }
        }
    }
};

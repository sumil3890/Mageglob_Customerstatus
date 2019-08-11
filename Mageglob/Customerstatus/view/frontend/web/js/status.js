
define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (Component, customerData) {
        'use strict';
        return Component.extend({
            initialize: function () {
                this.status = customerData.get('status');
                this._super();
            },
        });
    }
);

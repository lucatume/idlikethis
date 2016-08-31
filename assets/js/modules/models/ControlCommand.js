var Backbone = require('backbone'),
    data = require('localized-data');

module.exports = Backbone.Model.extend({

    sync: function () {
            Backbone.sync('create', this, {
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-WP-NONCE', data.endpoints.nonce);
                },
            });

    }
});

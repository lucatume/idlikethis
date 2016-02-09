var data = require('localized-data'),
    Backbone = require('backbone');

module.exports = Backbone.Model.extend({

    url: data.endpoints.button_click.url,

    sync: function () {

        Backbone.sync('create', this, {
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-NONCE', data.endpoints.nonce);
            },
        });

    },

});

var Backbone = require('backbone');

module.exports = Backbone.Model.extend({

    sync: function () {
            Backbone.sync('create', this, {
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-WP-NONCE', this.nonce);
                },
            });

    }
});

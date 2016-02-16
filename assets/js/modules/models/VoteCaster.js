var data = require('localized-data'),
    Backbone = require('backbone'),
    lscache = require('storage');

module.exports = Backbone.Model.extend({

    url: data.endpoints.button_click.url,

    hasVoted: function () {
        var votes = lscache.get('idlikethis').votes;
        if (votes === undefined || !votes) {
            return false;
        }
        return undefined === votes[this.get('hash')] ? false : votes[this.get('hash')];
    },

    sync: function () {

        if (this.hasVoted()) {
            console.log('has voted');
            return;
        }

        Backbone.sync('create', this, {
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-NONCE', data.endpoints.nonce);
            },
        });

        var stored = lscache.get('idlikethis'),
            votes = stored.votes;
        if (votes === undefined || votes === false) {
            return;
        }
        stored.votes[this.get('hash')] = true;
        lscache.set('idlikethis', stored, 60);
        console.log('has not voted');
    },

});

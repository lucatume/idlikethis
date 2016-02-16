var Backbone = require('backbone'),
    VoteCaster = require('models/VoteCaster');

module.exports = Backbone.View.extend({
    initialize: function (hash) {
        if (hash && hash.model !== undefined) {
            this.model = hash.model;
        } else {
            this.model = new VoteCaster({
                post_id: this.$el.data('post-id'),
                content: this.$el.data('text'),
                hash: this.$el.data('post-id') + this.$el.data('text'),
            });
        }
    },

    castVote: function () {
        this.model.save();
    },

    events: {
        'click': 'castVote',
    }
});

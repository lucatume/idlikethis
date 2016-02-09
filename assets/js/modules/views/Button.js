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
            });
        }
    },

    castVote: function () {
        console.log(this.model.toJSON());
        this.model.save();
    },

    events: {
        'click': 'castVote',
    }
});

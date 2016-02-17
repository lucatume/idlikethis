var Backbone = require('backbone');

module.exports = Backbone.View.extend({
    initialize: function (hash) {
        this.model.set('post_id', this.$el.data('post-id'));
    },

    command: function (evt) {
        evt.preventDefault();
        this.model.save();
    },

    events: {
        'click': 'command'
    }
});

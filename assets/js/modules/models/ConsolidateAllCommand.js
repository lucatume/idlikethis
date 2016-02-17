var ControlCommand = require('models/ControlCommand'),
    data = require('localized-data');

module.exports = ControlCommand.extend({
    url: data.endpoints.consolidate_all.url
});


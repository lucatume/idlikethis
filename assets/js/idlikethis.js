require("./../css/modules/idlikethis-button-simple.scss");

var Backbone = require('./modules/backbone.js'),
    $ = require('./modules/jquery.js'),
    idlikethis_ButtonView = require('./modules/views/Button.js');


function idlikethis_bootstrap() {
    // create a Backbone view on each button
    $('.idlikethis-button').each(function (button) {
        new idlikethis_ButtonView({el: button});
    });
};

$(idlikethis_bootstrap);

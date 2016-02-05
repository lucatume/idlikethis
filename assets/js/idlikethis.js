(function () {
    require("./../css/modules/idlikethis-button-simple.scss");

    require('./modules/underscore.js');
    require('./modules/backbone.js');

    var idlikethis = require('./modules/app.js'),
        $ = require('./modules/jquery.js');


    function bootstrap() {
        // create a Backbone view on each button
        $('.idlikethis-button').each(function (button) {
            new idlikethis.Views.Button({el: button});
        });
    };

    $(bootstrap);
})();

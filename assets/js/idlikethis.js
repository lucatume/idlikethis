(function () {
    require("../css/modules/idlikethis-button-simple.scss");

    var app = require('app'),
        $ = require('jquery');

    function bootstrap() {
        // create a Backbone view on each button
        $('.idlikethis-button').each(function (_, button) {
            new app.Views.Button({el: button});
        });
    };

    $(bootstrap);
})();

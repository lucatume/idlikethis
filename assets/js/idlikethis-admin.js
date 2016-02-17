(function () {
    require("../css/modules/idlikethis-post-control-meta-box.scss");

    var app = require('admin-app'),
        $ = require('jquery');

    function bootstrap() {
        var nonce = app.data.endpoints.nonce,
            resetAllUrl = app.data.endpoints.reset_all.url,
            consolidateAllUrl = app.data.endpoints.consolidate_all.url,
            resetAllButton = new app.Views.AdminControlButton({
                el: '#idlikethis-reset-all',
                model: new app.Models.ResetAllCommand({nonce: nonce, url: resetAllUrl})
            }),
            consolidateAllButton = new app.Views.AdminControlButton({
                el: '#idlikethis-consolidate-all',
                model: new app.Models.ConsolidateAllCommand({nonce: nonce, url: consolidateAllUrl})
            });
    };

    $(bootstrap);
})();

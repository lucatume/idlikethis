module.exports = {
    data: window.idlikethisData || {},
    Views: {
        AdminControlButton: require('views/AdminControlButton'),
    },
    Models: {
        ResetAllCommand: require('models/ResetAllCommand'),
        ConsolidateAllCommand: require('models/ConsolidateAllCommand'),
    }
};

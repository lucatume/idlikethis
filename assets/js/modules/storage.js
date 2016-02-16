var lscache = require('lscache');

lscache.set('idlikethis', {votes: {}});

module.exports = lscache;

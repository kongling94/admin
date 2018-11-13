'use strict';
const merge = require('webpack-merge');
const prodEnv = require('./prod.env');

module.exports = merge(prodEnv, {
    NODE_ENV: '"development"',
    API_ROOT: '"http://168.168.100.16/app_manage/server/public/api"' //设置
});

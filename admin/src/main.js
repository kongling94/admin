import Vue from 'vue';
import App from './App';
import router from './router';
import axios from 'axios';
import store from './store';
import VueClipboard from 'vue-clipboard2';
import ElementUI from 'element-ui';
import { post, get } from './api';
import echarts from 'echarts';

import 'element-ui/lib/theme-chalk/index.css'; // 默认主题
// import '../static/css/theme-green/index.css';       // 浅绿色主题
import '../static/css/icon.css';
import 'babel-polyfill';
const root = process.env.API_ROOT;
// 响应时间
axios.defaults.timeout = 5000;

// 配置cookie
// axios.defaults.withCredentials = true

// 配置接口地址
axios.defaults.baseURL = '/api';

Vue.use(ElementUI, { size: 'small' });
Vue.use(VueClipboard);

Vue.prototype.$post = post;
Vue.prototype.$get = get;
Vue.prototype.$echarts = echarts;
//使用钩子函数对路由进行权限跳转
/* router.beforeEach((to, from, next) => {
    const role = localStorage.getItem('username');
    if (!role && to.path !== '/login') {
        next('/login');
    } else if (to.meta.permission) {
        // 如果是管理员权限则可进入，这里只是简单的模拟管理员权限而已
        role === 'admin' ? next() : next('/403');
    } else {
        // 简单的判断IE10及以下不进入富文本编辑器，该组件不兼容
        if (navigator.userAgent.indexOf('MSIE') > -1 && to.path === '/editor') {
            Vue.prototype.$alert(
                'vue-quill-editor组件不兼容IE10及以下浏览器，请使用更高版本的浏览器查看',
                '浏览器不兼容通知',
                {
                    confirmButtonText: '确定'
                }
            );
        } else {
            next();
        }
    }
}); */

new Vue({
    el: '#app',
    router,
    store,
    components: { App },
    template: '<App/>'
});

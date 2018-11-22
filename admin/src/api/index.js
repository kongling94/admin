// 引入axios
import axios from 'axios';
import store from '../store';
// 序列化
import qs from 'qs';
// 引入element-ui 的 message组件
import { Message } from 'element-ui';

// 环境区分接口地址
const root = process.env.API_ROOT;

// 配置请求头
/* axios.defaults.headers.post['Content-Type'] =
    'application/x-www-form-urlencoded;charset=UTF-8'; */
function formatQuery(str) {
    let ary = str.split('&');
    let obj = {};
    ary.forEach((v, i) => {
        let result = v.split('=');
        obj[result[0]] = result[1];
    });
    return obj;
}
//http request 请求拦截器
axios.interceptors.request.use(
    config => {
        if (config.method == 'post') {
            const deviceType =
                localStorage.getItem('deviceType') ||
                formatQuery(config.data)['device_type'];
            const token = localStorage.getItem('token');
            token && (config.headers['XX-Token'] = token);
            deviceType && (config.headers['XX-Device-Type'] = deviceType);
            localStorage.setItem('deviceType', deviceType);
        }
        return config;
    },
    error => {
        return Promise.reject(err);
    }
);

// http response 响应拦截器
axios.interceptors.response.use(
    response => {
        // 200 请求成功
        if (response.status === 200) {
            if (response.data.code === 1) {
                return Promise.resolve(response);
            } else if (response.data.code === 10001) {
                tip('warning', response.data.msg);
                toLogin();
                store.commit('removeToken');
                return;
            } else {
                tip('warning', response.data.msg);
                return;
            }
        } else {
            return Promise.reject(response);
        }
    },
    error => {
        if (error.response.status) {
            switch (error.response) {
                // 未登录
                case 401:
                    toLogin();
                    break;
                // 登录超时
                case 403:
                    tip('warning', '登录过期，请重新登录!');
                    toLogin();
                    // 清除token
                    localStorage.removeItem('token');
                    store.commit('loginSuccess', null);
                    // 设置延时跳转
                    setTimeout(() => {}, 1000);
                    break;
                // 请求不存在
                case 404:
                    tip('error', '网络请求不存在.');
                    break;
                // 错误时，抛出错误
                default:
            }
            return Promise.reject(error.response);
        }
    }
);

/**
 * get方法，对应get请求
 * @param {String} url [请求的url地址]
 * @param {Object} params  [请求携带的参数]
 */
export function get(url, params) {
    return new Promise((resolve, reject) => {
        axios
            .get(root + url, {
                params: params
            })
            .then(res => {
                resolve(res.data);
            })
            .catch(err => {
                reject(err.data);
            });
    });
}

/**
 * post方法，对应post请求
 * @param {String} url [请求的url地址]
 * @param {Object} params [请求时携带的参数]
 */
export function post(url, options) {
    let opt = options || {};
    return new Promise((resolve, reject) => {
        axios({
            method: 'post',
            url: root + url,
            // 判断是否有自定义头部，以对参数进行序列化。不定义头部，默认对参数序列化为查询字符串。
            data: (opt.headers ? opt.data : qs.stringify(opt.data)) || {},
            responseType: opt.dataType || 'json',
            // 设置默认请求头
            headers: opt.headers || {
                'Content-Type':
                    'application/x-www-form-urlencoded; charset=UTF-8'
            }
        })
            .then(res => {
                resolve(res.data);
            })
            .catch(err => {
                reject(err.data);
            });
    });
}

const toLogin = () => {
    router.replace({
        path: '/login',
        query: {
            redirect: router.currentRoute.fullPath
        }
    });
};

const tip = (type, msg) => {
    Message({
        message: msg,
        type: type
    });
};

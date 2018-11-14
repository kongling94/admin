import * as types from './mutation-types';
//设置actions 是异步的修改state
/*  commit 提交
    state 数据（一般做获取）
    user 传入的值
*/
export const setUserName = function({ commit, state }, user) {
    //执行mutations中的types.SET_USERNAME方法，value为user
    commit(types.SET_USERNAME, user);
};
export const setToken = function({ commit, state }, token) {
    //执行mutations中的types.SET_USERNAME方法，value为user
    commit(types.SET_TOKEN, token);
};
export const removeToken = function({ commit, state }, token) {
    //执行mutations中的types.SET_USERNAME方法，value为user
    commit(types.REMOVE_TOKEN, token);
};
export const setDeviceType = function({ commit, state }, type) {
    //执行mutations中的types.SET_USERNAME方法，value为user
    commit(types.SET_DEVICE_TYPE, type);
};
export const setLoginInfo = function({ commit, state }, obj) {
    //执行mutations中的types.SET_USERNAME方法，value为user
    commit(types.SET_USERNAME, obj.username);
    commit(types.SET_TOKEN, obj.token);
    commit(types.SET_DEVICE_TYPE, obj.deviceType);
    commit(types.SET_TYPE, obj.type);
};

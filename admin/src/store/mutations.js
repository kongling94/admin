import * as types from './mutation-types';

const mutations = {
    [types.SET_USERNAME](state, user) {
        state.username = user;
        localStorage.setItem('username', user);
    },
    [types.SET_TOKEN](state, token) {
        state.token = token;
        localStorage.setItem('token', token);
    },
    [types.REMOVE_TOKEN](state) {
        state.token = '';
        localStorage.removeItem('token');
    },
    [types.SET_DEVICE_TYPE](state, type) {
        state.deviceType = type;
    },
    [types.SET_TYPE](state, type) {
        state.type = type;
        localStorage.setItem('type', type);
    }
};
export default mutations;

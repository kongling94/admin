//设置actions 是异步的修改state
/*  commit 提交
    state 数据
    user 传入的值
*/
export const setUser = function({ commit, state }, user) {
    //执行mutations中的SET_USER操作，value为user
    commit(types.SET_USER, user);
};

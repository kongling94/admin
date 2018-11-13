<template>
    <el-tabs @tab-click="handleClick"
             value="userList"
             class="tabs">
        <el-tab-pane label="用户列表"
                     name="userList">
            <tablelist :tableHeader="tableHeader"></tablelist>
        </el-tab-pane>
        <el-tab-pane label="用户地图"
                     name="userMap">
            <mapview></mapview>
        </el-tab-pane>
    </el-tabs>
</template>
<script>
import tablelist from './tableList'
import mapview from './map'
export default {
    name: 'updata',
    components: {
        tablelist,
        mapview
    },
    data () {
        return {
            tableHeader: [
                {
                    label: 'UID',
                    prop: 'uid'
                },
                {
                    label: 'APP名',
                    prop: 'appName'
                },
                {
                    label: '设备名',
                    prop: 'DeviceName'
                },
                {
                    label: '序列号',
                    prop: 'serialNumber'
                },
                {
                    label: '地区',
                    prop: 'region'
                },
                {
                    label: '激活时间',
                    prop: 'ActivationTime'
                },
                {
                    label: '已用时间',
                    prop: 'ElapsedTime'
                },
                {
                    label: 'IP',
                    prop: 'ip'
                },
                {
                    label: '备注',
                    prop: 'remark'
                }
            ]
        }
    },
    methods: {
        handleClick (tab, event) {
            // console.log(tab, event);
        }
    }
}
</script>
<style lang="stylus" scoped>
.tabs
    margin-top 12px
    >>>.el-tabs__nav-wrap
        margin 0 20px
        font-size 24px
        .el-tabs__item
            font-size 16px
</style>


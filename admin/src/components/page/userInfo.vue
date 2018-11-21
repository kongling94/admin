<template>
    <el-tabs @tab-click="handleClick"
             value="userList"
             class="tabs">
        <el-tab-pane label="用户列表"
                     name="userList">
            <tablelist :tableHeader="tableHeader"
                       :tableData="userList"></tablelist>
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
            userList: [],
            tableHeader: [
                {
                    label: 'UID',
                    prop: 'id'
                },
                {
                    label: 'APP名',
                    prop: 'app_name'
                },
                {
                    label: '设备名',
                    prop: 'device_name'
                },
                {
                    label: '序列号',
                    prop: 'sn'
                },
                {
                    label: '地区',
                    prop: 'country'
                },
                {
                    label: '激活时间',
                    prop: 'create_time'
                },
                {
                    label: '已用时间',
                    prop: 'used_time'
                },
                {
                    label: 'IP',
                    prop: 'ip'
                },
                {
                    label: '备注',
                    prop: 'longitude'
                }
            ]
        }
    },
    methods: {
        _getUserData () {
            this.$post('/device/list').then(res => {
                if (res.code === 1) {
                    this.userList = res.data.list
                }
            })
        },
        handleClick (tab, event) {
            // console.log(tab, event);
        }
    },
    mounted () {
        this._getUserData()
    },
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


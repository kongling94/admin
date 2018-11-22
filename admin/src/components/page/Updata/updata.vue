<template>
    <div class="userinfo">
        <el-row class="userinfo-title"
                type="flex"
                justify="space-between">
            <el-col :span="12"
                    class="title_text">
                <span>应用列表</span>
            </el-col>
            <el-col :span="12"
                    class="title_addBtn">
                <button type="button"
                        class="el-button el-button--primary add-application"
                        @click="openDialog_add">添加应用</button>
            </el-col>
        </el-row>
        <div class="userinfo-list">
            <tablelist :tableHeader="tableHeader"
                       :tableData="tableData"
                       :showControl=true
                       @updataDialog="updataDialog"
                       ref="tableList"
                       @isUploaded="_getData"></tablelist>
        </div>
        <updataDialog :showDialog="showDialog"
                      :isUpdata="isUpdata"
                      :dialogData="dialogData"
                      @watchDialog="closeDialog"
                      @isUploaded="_getData"></updataDialog>
    </div>

</template>
<script>
import tablelist from 'common/tableList'
import updataDialog from './updataDialog'
import { Loading } from 'element-ui';

export default {
    name: 'userInfo',
    components: {
        tablelist,
        updataDialog
    },
    data () {
        return {
            showDialog: false,
            tableHeader: [
                {
                    label: 'UID',
                    prop: 'id'
                },
                {
                    label: 'APP名',
                    prop: 'name'
                },
                {
                    label: '当前版本',
                    prop: 'appversion[0].version_name'
                },
                {
                    label: '发布时间',
                    prop: 'create_time'
                },
                {
                    label: '最近更新',
                    prop: 'appversion[0].create_time'
                },
                {
                    label: '下载量',
                    prop: 'appversion[0].count'
                },
            ],
            tableData: [],
            isUpdata: false,
            dialogData: null
        }
    },
    methods: {
        _getData () {
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });

            this.$post("/admin/app").then(res => {
                if (res.code === 1) {
                    this.tableData = res.data.list
                    loading.close();
                } else if (res.code === 0) {
                    this.$message({
                        message: res.msg,
                        type: 'error'
                    });
                } else if (res.code === 10001) {
                    this.$message({
                        message: res.msg,
                        type: 'error'
                    });

                    loading.close();

                    this.$router.push('/login');
                }
            })
        },
        openDialog_add () {
            this.dialogData = null
            this.isUpdata = false
            this.showDialog = true
        },
        closeDialog () {
            this.showDialog = false
        },
        updataDialog (data) {
            this.isUpdata = true
            // 赋值给props过去的数据
            this.dialogData = data
            this.showDialog = true
        }

    },
    mounted () {
        this._getData()
    },
}
</script>
<style lang="stylus" scoped>
/* .formDialog >>> .el-upload--text
display inline-block
width 80px
height 30px
border none */
.userinfo
    .userinfo-title
        height 55px
        line-height 35px
        padding 10px 0
        margin 0 20px
        border-bottom 1px solid #e6e5e6
        .title_text
            margin-top 5px
            color #52b2fb
            span
                position relative
                &::after
                    content ''
                    position absolute
                    bottom -14px
                    left 0
                    width calc(100% + 5px)
                    height 2px
                    background-color #52b2fb
        .title_addBtn
            text-align right
            .add-application
                padding 0
                // margin 0
                width 120px
                height 35px
                // line-height 35px
    .userinfo-list
        padding 20px 0
</style>


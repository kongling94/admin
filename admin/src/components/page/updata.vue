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
                        @click="openDialog">添加应用</button>
            </el-col>
        </el-row>
        <div class="userinfo-list">
            <el-table :data="tableData"
                      style="width: 100%"
                      :header-cell-style="styleHeaderBg"
                      :cell-style="styleCell"
                      :row-class-name="styleRowBg">
                <el-table-column prop="uid"
                                 label="UID"
                                 width="150">
                </el-table-column>
                <el-table-column prop="appName"
                                 label="APP名">
                </el-table-column>
                <el-table-column prop="currentVersion"
                                 label="当前版本">
                </el-table-column>
                <el-table-column prop="releaseTime"
                                 label="发布时间">
                </el-table-column>
                <el-table-column prop="recentUpdates"
                                 label="最近更新">
                </el-table-column>
                <el-table-column prop="downloads"
                                 label="下载量">
                </el-table-column>
                <el-table-column prop="handle"
                                 label="操作"
                                 width="150">
                    <template slot-scope="scope">
                        <el-button @click="handleUpdata(scope.row)"
                                   type="text"
                                   size="normal">版本更新</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <el-dialog title="添加应用"
                   :visible.sync="showDialog"
                   width="32%"
                   :rules="formRules"
                   :before-close="cancelDialog"
                   center
                   ref="addApplication">
            <el-form :label-position="labelPosition"
                     label-width="80px"
                     :model="addForm"
                     class="formDialog">
                <el-form-item label="应用名"
                              prop="name">
                    <el-input v-model="addForm.name"
                              placeholder="请输入名称"></el-input>
                </el-form-item>
                <el-form-item label="版本号"
                              prop="version">
                    <el-input v-model="addForm.version"
                              placeholder="请输入版本号"></el-input>
                </el-form-item>
                <el-form-item label="上传文件"
                              prop="file">
                    <el-input v-model="addForm.file"
                              class="form_file"
                              ref="formFileInput"></el-input>
                    <el-upload action="https://jsonplaceholder.typicode.com/posts/"
                               :before-upload="handleChange"
                               accept=".apk,.jpg"
                               :limit="1"
                               :file-list="fileList"
                               class="uploadFile">
                        <el-button size="small"
                                   type="primary">点击上传</el-button>
                    </el-upload>
                </el-form-item>
                <el-form-item label="版本说明"
                              prop="desc">
                    <el-input type="textarea"
                              placeholder="请输入更新内容"
                              v-model="addForm.desc"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer"
                  class="dialog-footer">
                <el-button @click="showDialog = false">取 消</el-button>
                <el-button type="primary"
                           @click="showDialog = false">确 定</el-button>
            </span>
        </el-dialog>
    </div>

</template>
<script>
export default {
    name: 'userInfo',

    data () {
        return {
            showDialog: false,
            labelPosition: 'left',
            addForm: {
                name: '',
                version: '',
                file: '',
                desc: ''
            },
            formRules: {
                name: [
                    { required: true, message: '请输入名称', trigger: 'blur' },
                    { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                ],
                version: [
                    { required: true, message: '请输入一个版本号', trigger: 'change' }
                ],
                file: [
                    { required: true, message: '请选择需要文件', trigger: 'change' }
                ],
                desc: [
                    { required: true, message: '请填写活动形式', trigger: 'blur' }
                ]
            },
            fileList: [{
                name: 'firefly.apk',
                url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'
            }],
            tableData: [
                {
                    uid: '001',
                    appName: '王小虎',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 1021,

                },
                {
                    uid: '002',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,

                },
                {
                    uid: '003',
                    appName: '赵小狗',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 3021,

                }
            ]
        }
    },
    methods: {
        styleHeaderBg ({ row, rowIndex }) {
            return "background-color:#e7eff5;font-size:14px;font-weight:normal;color:#959595;"
        },
        styleRowBg ({ row, rowIndex }) {
            return "background-color:#f5f9fb;"
        },
        styleCell ({ row, rowIndex }) {
            return "font-size:14px;color:#959595;"
        },
        handleUpdata (row) {
            alert("这边逻辑是啥？")
        },
        openDialog () {
            this.showDialog = true
            this.$refs.formFileInput.values = 'XXXX.apk'
        },
        cancelDialog () {
            this.showDialog = false
        },
        handleChange (file, fileList) {

            // this.fileList = fileList.slice(-1);
        }
    },
    mounted () {
        // const this.$refs.formFileInput
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
    padding 0 20px
    font-size 18px
    .userinfo-title
        height 55px
        line-height 35px
        padding 10px 0
        border-bottom 1px solid #e6e5e6
        .title_text
            margin-top 5px
            color #52b2fb
            span
                position relative
                &::after
                    content ''
                    position absolute
                    bottom -13px
                    left 0
                    width calc(100% + 5px)
                    height 1px
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
    .formDialog
        padding 0 25px
        .el-form-item
            margin-bottom 24px
            .el-input, .el-textarea
                width 400px
            .form_file
                width 312px
</style>


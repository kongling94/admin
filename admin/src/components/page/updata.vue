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
            <tablelist :tableHeader="tableHeader"
                       :tableData="tableData"
                       :showControl=true></tablelist>
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
                    <!-- <el-input v-model="addForm.file"
                              class="form_file"
                              ref="formFileInput"
                              value="这个是什么"></el-input> -->
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
                              class="form_textarea"
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
import tablelist from './tableList'
export default {
    name: 'userInfo',
    components: {
        tablelist
    },
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
            }]
        }
    },
    methods: {
        _getData () {
            this.$post("/admin/app").then(res => {
                if (res.code === 1) {
                    this.tableData = res.data.list
                }
            })
        },
        openDialog () {
            this.showDialog = true
        },
        cancelDialog () {
            this.showDialog = false
        },
        handleChange (file, fileList) {
            this.fileList = fileList.slice(-1);
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
.uploadFile >>> .el-upload--text
    width 80px
    height 32px
    border none
    float right
.uploadFile >>> .el-upload-list
    width 312px
    height 32px
    border 1px solid #dcdfe6
    border-radius 4px
    float left
    .el-upload-list__item:first-child
        // height 100%
        // height 32px
        margin-top 5px
        &:hover
            background-color #fff
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
    .el-dialog__wrapper
        // box-sizing border-box
        .el-dialog__body
            .formDialog
                padding 0 25px
                .el-form-item
                    margin-bottom 24px
                    .el-form-item__label
                        font-size 16px
                    .el-input, .el-textarea
                        width 400px
                        >>>.el-textarea__inner
                            height 200px
                            resize none
                    .form_file
                        width 312px
                    &:last-child
                        margin-bottom 0
        .el-dialog__footer
            margin-bottom 35px
            .el-button
                width 135px
                height 40px
                &:last-child
                    margin-left 90px
</style>


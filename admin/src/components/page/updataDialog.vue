<template>
    <div class="dialog">
        <el-dialog :title="isUpdata?'更新版本':'添加应用'"
                   :visible.sync="showDialog"
                   width="32%"
                   :rules="formRules"
                   :before-close="cancelDialog"
                   center
                   @open="openDialog"
                   ref="addApplication">
            <el-form :label-position="labelPosition"
                     label-width="80px"
                     class="formDialog"
                     ref="addFormData"
                     :model="addFormData">
                <el-form-item label="应用名"
                              prop="name">
                    <el-input v-model="addFormData.name"
                              placeholder="请输入名称"></el-input>
                </el-form-item>
                <el-form-item label="版本号"
                              prop="version_name">
                    <el-input v-model="addFormData.version_name"
                              placeholder="请输入版本号"></el-input>
                </el-form-item>
                <el-form-item label="上传文件"
                              prop="file">
                    <!-- <el-input v-model="addForm.file"
                              class="form_file"
                              ref="formFileInput"
                              value="这个是什么"></el-input> -->
                    <el-upload action=""
                               ref="upload"
                               :before-upload="beforeUpload"
                               accept=".apk,.jpg"
                               :limit="1"
                               :auto-upload="false"
                               :file-list="addFormData.fileList"
                               class="uploadFile">
                        <el-button size="small"
                                   type="primary">点击上传</el-button>
                    </el-upload>
                </el-form-item>
                <el-form-item label="版本说明"
                              prop="content">
                    <el-input type="textarea"
                              class="form_textarea"
                              placeholder="请输入更新内容"
                              v-model="addFormData.content"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer"
                  class="dialog-footer">
                <el-button @click="cancelDialog">取 消</el-button>
                <el-button type="primary"
                           @click="submitForm">确 定</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
import Newapp from '../common/dom.js'
import { Message } from 'element-ui'
export default {
    name: 'updataDialog',
    props: {
        showDialog: {
            type: Boolean,
            default: false
        },
        dialogData: {
            type: Object
        },
        isUpdata: {
            type: Boolean,
            default: false
        }
    },
    data () {
        return {
            labelPosition: 'left',
            formRules: {
                name: [
                    { required: true, message: '请输入名称', trigger: 'blur' },
                    { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                ],
                version_name: [
                    { required: true, message: '请输入一个版本号', trigger: 'blur' }
                ],
                file: [
                    { required: true, message: '请选择需要文件', trigger: 'change' }
                ],
                content: [
                    { required: true, message: '请填写活动形式', trigger: 'blur' }
                ]
            },
            addFormData: {
                name: '',
                version_name: '',
                content: '',
                fileList: [
                    {
                        name: '',
                        url: ''
                    }
                ]
            },
        }
    },
    methods: {
        // _uploadForm (obj) {
        //     this.$post('/admin/appversion/add', obj).then(res => {
        //         if (res.code === 1) {
        //             res = res.data
        //             Message({
        //                 type: 'success',
        //                 message: res.msg
        //             })
        //         }
        //     })
        // },
        openDialog () {

            if (this.isUpdata && this.dialogData) {
                this.addFormData = new Newapp(this.dialogData)
                console.log(new Newapp(this.dialogData))
            } else {
                return this.addFormData = {
                    name: '',
                    version_name: '',
                    content: ''
                }
            }
        },
        submitForm () {
            this.$refs.upload.submit()
        },
        beforeUpload (file) {
            let fd = new FormData()
            fd.append('file', file)
            fd.append('name', this.addFormData.name)
            fd.append('version_name', this.addFormData.version_name)
            fd.append('content', this.addFormData.content)
            this.$post('/admin/appversion/add', {
                data: fd,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(res => {
                if (res.code === 1) {
                    this.cancelDialog()
                    Message({
                        type: 'success',
                        message: res.msg
                    })
                    this.$emit('isUploaded')
                }
            })
            return true
        },
        cancelDialog () {
            this.addFormData = {
                name: '',
                version_name: '',
                content: ''
            }
            this.$emit('watchDialog')
        },
    },
    computed: {

    },
    created () {
        // console.log(this.dialogData)
    },
    mounted () {

    },
}
</script>
<style lang="stylus" scoped>
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

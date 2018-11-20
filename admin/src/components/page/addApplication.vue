<template>
    <el-dialog title="添加应用"
               :visible.sync="showDialog"
               width="32%"
               :before-close="changeDialog"
               center
               ref="addApplication">
        <el-form :label-position="labelPosition"
                 label-width="80px"
                 :model="formLabelAlign">
            <el-form-item label="名称">
                <el-input v-model="formLabelAlign.name"></el-input>
            </el-form-item>
            <el-form-item label="活动区域">
                <el-input v-model="formLabelAlign.region"></el-input>
            </el-form-item>
            <el-form-item label="活动形式">
                <el-input v-model="formLabelAlign.type"></el-input>
            </el-form-item>
        </el-form>
        <span slot="footer"
              class="dialog-footer">
            <el-button @click="changeDialog">取 消</el-button>
            <el-button type="primary"
                       @click="showDialog = false">确 定</el-button>
        </span>
    </el-dialog>

</template>
<script>
export default {
    name: 'addApplication',

    data () {
        return {
            showDialog: this.dialogVisible,
            labelPosition: 'left',
            formLabelAlign: {
                name: '',
                region: '',
                type: ''
            }
        }
    },
    methods: {
        changeDialog () {
            this.$emit(dialogStatus, this.showDialog)
        },
        handleClose () {
            this.$confirm('确认关闭？')
                .then(_ => {
                    this.showDialog = false
                    done();
                })
                .catch(_ => { });
        }
    },
    mounted () {
        console.log(this.showDialog)
    },
}
</script>
<style lang="stylus" scoped>
</style>

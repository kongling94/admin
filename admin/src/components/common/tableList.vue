<template>
    <div class="tableList">
        <el-table v-show="tableData"
                  :data="currentPageData"
                  style="width: 100%"
                  :header-cell-style="styleHeaderBg"
                  :cell-style="styleCell"
                  :row-class-name="styleRowBg">

            <el-table-column v-for="item in tableHeader"
                             :key="item.id"
                             :prop="item.prop"
                             :label="item.label">
            </el-table-column>

            <el-table-column prop="handle"
                             label="操作"
                             width="200"
                             v-if="showControl">
                <template slot-scope="scope">
                    <el-button @click="handleUpdata(scope.row)"
                               type="primary"
                               size="mini">版本更新</el-button>
                    <el-button @click="copyAddress(scope.$index,scope.row)"
                               type="info"
                               size="mini">复制链接</el-button>

                </template>
            </el-table-column>
        </el-table>
        <el-row class="tableList_footer">
            <el-button type="primary"
                       icon="el-icon-lx-refresh"
                       class="refreshBtn"
                       @click="refreshTable"></el-button>
            <el-pagination background
                           class="pages"
                           layout="prev, pager, next"
                           :page-size="20"
                           :current-page.sync="page"
                           @current-change="handleCurrentChange"
                           :total="totalData.length">
            </el-pagination>
        </el-row>
    </div>
</template>
<script>
import { Message } from 'element-ui'

export default {
    name: 'tableList',
    props: {
        tableHeader: {
            type: Array
        },
        tableData: {
            type: Array,
            default: []
        },
        showControl: {
            type: Boolean,
            default: false
        }
    },
    data () {
        return {
            page: 1,
            pageSize: 20,
            totalData: [],
            currentPageData: []
        }
    },
    methods: {
        refreshTable () {
            this.$emit('isUploaded')
            this.handleCurrentChange(1)
            this.page = 1
        },
        copyAddress (index, row) {
            this.$copyText(row.link).then((res) => {
                Message({
                    message: '复制成功',
                    type: 'success'
                })
            }, (err) => {
                Message({
                    message: '复制失败',
                    type: 'error'
                })
            })
        },
        handleUpdata (row) {
            this.$emit('updataDialog', row)
        },
        styleHeaderBg ({ row, rowIndex }) {
            return "background-color:#e7eff5;font-size:14px;font-weight:normal;color:#959595;"
        },
        styleRowBg ({ row, rowIndex }) {
            return "background-color:#f5f9fb;"
        },
        styleCell ({ row, rowIndex }) {
            return "font-size:14px;color:#959595;"
        },
        handleCurrentChange (curPage) {
            let total = this.totalData
            let maxPage = Math.floor(total / this.pageSize);
            let minPage = curPage < 1 ? 1 : curPage;
            curPage = curPage > maxPage ? maxPage : curPage
            this.page = curPage
            return this.currentPageData = total.slice((curPage - 1) * this.pageSize, curPage * this.pageSize)
        },
        initData (ary) {
            this.totalData = ary
        }
    },
    watch: {
        currentPageData (newVal) {
            this.currentPageData = newVal
        },
        tableData (newVal) {
            this.initData(newVal)
            this.handleCurrentChange(1)
        }
    },
    created () {
        setTimeout(() => {
            // this.initData(this.tableData)
            this.handleCurrentChange(1)
        }, 1000)
    },
    mounted () {

    }
}
</script>
<style lang="stylus" scoped>
.tableList
    padding 0 20px
    font-size 18px
    .tableList_footer
        text-align right
        margin-top 25px
        .refreshBtn
            vertical-align bottom
            height 32px
            font-size 14px
        .pages
            display inline-block
            // padding-left 50px
</style>

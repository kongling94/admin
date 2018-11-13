<template>
    <div class="tableList">
        <el-table :data="tableData"
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
                             width="150"
                             v-if="showControl">
                <template slot-scope="scope">
                    <el-button @click="handleUpdata(scope.row)"
                               type="text"
                               size="normal">版本更新</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination background
                       class="pages"
                       layout="prev, pager, next"
                       :page-size="10"
                       @current-change="handleCurrentChange"
                       :total="totalData.length">
        </el-pagination>
    </div>
</template>
<script>
export default {
    name: 'tableList',
    props: {
        tableHeader: {
            type: Array
        },
        showControl: {
            type: Boolean,
            default: false
        }
    },
    data () {
        return {
            page: 1,
            pageSize: 10,
            // tableHeader: [],
            totalData: [
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
                },
                {
                    uid: '004',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,
                },
                {
                    uid: '005',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,
                },
                {
                    uid: '006',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,
                },
                {
                    uid: '007',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,
                },
                {
                    uid: '008',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,
                }, {
                    uid: '009',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,
                },
                {
                    uid: '010',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,
                },
                {
                    uid: '011',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,
                },
                {
                    uid: '012',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,
                },
                {
                    uid: '013',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,
                },
                {
                    uid: '014',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,
                },
                {
                    uid: '015',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,
                },
                {
                    uid: '016',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021,
                },
                {
                    uid: '017',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021
                },
                {
                    uid: '018',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021
                },
                {
                    uid: '019',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021
                },
                {
                    uid: '020',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021
                },
                {
                    uid: '021',
                    appName: '李小猪',
                    currentVersion: '1.25',
                    releaseTime: '2017-05-06',
                    recentUpdates: '2018-09-05',
                    downloads: 13021
                }
            ],
            tableData: [

            ]
        }
    },
    methods: {
        handleUpdata (row) {
            alert("这边逻辑是啥？")
            console.log()
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
            // console.log(curPage)
            let total = this.totalData
            let maxPage = Math.floor(total / this.pageSize);
            let minPage = curPage < 1 ? 1 : curPage;
            curPage = curPage > maxPage ? maxPage : curPage
            return this.tableData = total.slice((curPage - 1) * this.pageSize, curPage * this.pageSize)

        }
    },
    watch: {
        tableData (newVal, oldVal) {
            this.tableData = newVal
        }
    },
    mounted () {
        this.handleCurrentChange(1)
        // console.log(this.showControl)
    },
}
</script>
<style lang="stylus" scoped>
.tableList
    padding 0 20px
    font-size 18px
    .pages
        margin-top 25px
        text-align right
</style>

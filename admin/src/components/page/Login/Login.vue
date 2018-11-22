<template>
    <div class="login-wrap">
        <div class="ms-login">
            <div class="ms-title">后台管理系统</div>
            <el-form :model="ruleForm"
                     :rules="rules"
                     ref="ruleForm"
                     label-width="0px"
                     class="ms-content">
                <el-form-item prop="username">
                    <el-input v-model="ruleForm.username"
                              placeholder="用户名">
                        <el-button slot="prepend"
                                   icon="el-icon-lx-people"></el-button>
                    </el-input>
                </el-form-item>
                <el-form-item prop="password">
                    <el-input type="password"
                              placeholder="密码"
                              v-model="ruleForm.password"
                              @keyup.enter.native="login('ruleForm')">
                        <el-button slot="prepend"
                                   icon="el-icon-lx-lock"></el-button>
                    </el-input>
                </el-form-item>
                <div class="login-btn">
                    <el-button type="primary"
                               @click="login('ruleForm')">登录</el-button>
                </div>
                <p class="login-tips"></p>
            </el-form>
        </div>
    </div>
</template>

<script>
import { post, get } from 'api'
import { mapActions } from 'vuex';
export default {
    data: function () {
        return {
            ruleForm: {
                username: '',
                password: ''
            },
            rules: {
                username: [
                    { required: true, message: '请输入用户名', trigger: 'blur' }
                ],
                password: [
                    { required: true, message: '请输入密码', trigger: 'blur' }
                ]
            }
        }
    },
    methods: {
        ...mapActions([
            'setLoginInfo'
        ]),
        //提交登录
        submitForm (formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.login()
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        login () {
            this.$post("/admin/public/login", {
                data: {
                    username: this.ruleForm.username,
                    password: this.ruleForm.password,
                    device_type: 'web'
                }
            }).then((res) => {
                if (res.code === 1) {
                    this.$message({
                        message: res.msg,
                        type: 'success'
                    });
                    const data = res.data
                    data.deviceType = localStorage.getItem("deviceType")
                    this.setLoginInfo(data)
                    // localStorage.setItem('username', this.ruleForm.username);
                    this.$router.push('/');
                }
            })
        }
    },
    created () {

    },
}
</script>

<style scoped>
.login-wrap {
  position: relative;
  width: 100%;
  height: 100%;
  background-image: url(../../../assets/images/login-bg.jpg);
  background-size: 100%;
}
.ms-title {
  width: 100%;
  line-height: 50px;
  text-align: center;
  font-size: 20px;
  color: #fff;
  border-bottom: 1px solid #ddd;
}
.ms-login {
  position: absolute;
  left: 50%;
  top: 50%;
  width: 350px;
  margin: -190px 0 0 -175px;
  border-radius: 5px;
  background: rgba(255, 255, 255, 0.3);
  overflow: hidden;
}
.ms-content {
  padding: 30px 30px;
}
.login-btn {
  text-align: center;
}
.login-btn button {
  width: 100%;
  height: 36px;
  margin-bottom: 10px;
}
.login-tips {
  font-size: 12px;
  line-height: 30px;
  color: #fff;
}
</style>

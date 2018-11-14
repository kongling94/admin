<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace api\device\controller;

use think\Db;
use think\Validate;
use cmf\controller\RestBaseController;

class PublicController extends RestBaseController
{
    // 设备注册
    public function register()
    {
        $validate = new Validate([
            'app_name'          => 'require',
            'device_name'       => 'require',
            'sn'                => 'require',
            'ip'                => 'require',
            'longitude'         => 'require',
            'latitude'          => 'require',
        ]);

        $validate->message([
            'app_name.require'          => '应用名为空',
            'device_name.require'       => '设备名为空',
            'sn.require'                => '序列号为空',
            'ip.require'                => 'ip为空',
            'longitude.require'         => '经度为空',
            'latitude.require'          => '纬度为空',

        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $user = [];

        $findDeviceWhere['sn'] = $data['sn'];
        $findDeviceCount['app_name'] = $data['app_name'];

        // if (Validate::is($data['username'], 'email')) {
        //     $user['user_email']          = $data['username'];
        //     $findDeviceWhere['user_email'] = $data['username'];
        // } else if (cmf_check_mobile($data['username'])) {
        //     $user['mobile']          = $data['username'];
        //     $findDeviceWhere['mobile'] = $data['username'];
        // } else {
        //     $this->error("请输入正确的手机或者邮箱格式!");
        // }

        // $errMsg = cmf_check_verification_code($data['username'], $data['verification_code']);
        // if (!empty($errMsg)) {
        //     $this->error($errMsg);
        // }

        $findDeviceCount = Db::name("device")->where($findDeviceWhere)->count();

        if ($findDeviceCount > 0) {
            $this->error("此应用已激活!");
        }

        $is_app = Db::name('app')->where(['name'=>$data['app_name']])->find();
        if(!$is_app){
            $this->error("应用不存在!");
        }
        // $user['create_time'] = time();
        // $user['user_status'] = 1;
        // $user['user_type']   = 2;
        // $user['user_pass']   = cmf_password($data['password']);

        $data['create_time'] = time();
        $data['ip'] = $data['ip'];
        $data['status'] = 1;


        $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$data['ip'];
        $ip_data=json_decode(file_get_contents($url), true);
        
        if($ip_data && $ip_data['code'] == 0){
            $data['country'] = $ip_data['data']['country'];
            $data['area'] = $ip_data['data']['area'];
            $data['region'] = $ip_data['data']['region'];
            $data['city'] = $ip_data['data']['city'];
            $data['county'] = $ip_data['data']['county'];
            $data['isp'] = $ip_data['data']['isp'];
        }
        // dump($ip_data);exit();
        $result = Db::name("device")->insert($data);


        if (empty($result)) {
            $this->error("应用激活失败,请重试!");
        }

        $this->success("应用激活成功!");

    }

    // 用户登录 TODO 增加最后登录信息记录,如 ip
    public function login()
    {
        $validate = new Validate([
            'username' => 'require',
            'password' => 'require'
        ]);
        $validate->message([
            'username.require' => '请输入手机号,邮箱或用户名!',
            'password.require' => '请输入您的密码!'
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $findUserWhere = [];

        if (Validate::is($data['username'], 'email')) {
            $findUserWhere['user_email'] = $data['username'];
        } else if (cmf_check_mobile($data['username'])) {
            $findUserWhere['mobile'] = $data['username'];
        } else {
            $findUserWhere['user_login'] = $data['username'];
        }

        $findUser = Db::name("user")->where($findUserWhere)->find();

        if (empty($findUser)) {
            $this->error("用户不存在!");
        } else {

            switch ($findUser['user_status']) {
                case 0:
                    $this->error('您已被拉黑!');
                case 2:
                    $this->error('账户还没有验证成功!');
            }

            if (!cmf_compare_password($data['password'], $findUser['user_pass'])) {
                $this->error("密码不正确!");
            }
        }

        $allowedDeviceTypes = $this->allowedDeviceTypes;

        if (empty($data['device_type']) || !in_array($data['device_type'], $allowedDeviceTypes)) {
            $this->error("请求错误,未知设备!");
        }

        $userTokenQuery = Db::name("user_token")
            ->where('user_id', $findUser['id'])
            ->where('device_type', $data['device_type']);
        $findUserToken  = $userTokenQuery->find();
        $currentTime    = time();
        $expireTime     = $currentTime + 24 * 3600 * 180;
        $token          = md5(uniqid()) . md5(uniqid());
        if (empty($findUserToken)) {
            $result = $userTokenQuery->insert([
                'token'       => $token,
                'user_id'     => $findUser['id'],
                'expire_time' => $expireTime,
                'create_time' => $currentTime,
                'device_type' => $data['device_type']
            ]);
        } else {
            $result = $userTokenQuery
                ->where('user_id', $findUser['id'])
                ->where('device_type', $data['device_type'])
                ->update([
                    'token'       => $token,
                    'expire_time' => $expireTime,
                    'create_time' => $currentTime
                ]);
        }


        if (empty($result)) {
            $this->error("登录失败!");
        }

        $this->success("登录成功!", ['token' => $token, 'user' => $findUser]);
    }

    // 用户退出
    public function logout()
    {
        $userId = $this->getUserId();
        Db::name('user_token')->where([
            'token'       => $this->token,
            'user_id'     => $userId,
            'device_type' => $this->deviceType
        ])->update(['token' => '']);

        $this->success("退出成功!");
    }

    // 用户密码重置
    public function passwordReset()
    {
        $validate = new Validate([
            'username'          => 'require',
            'password'          => 'require',
            'verification_code' => 'require'
        ]);

        $validate->message([
            'username.require'          => '请输入手机号,邮箱!',
            'password.require'          => '请输入您的密码!',
            'verification_code.require' => '请输入数字验证码!'
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $userWhere = [];
        if (Validate::is($data['username'], 'email')) {
            $userWhere['user_email'] = $data['username'];
        } else if (cmf_check_mobile($data['username'])) {
            $userWhere['mobile'] = $data['username'];
        } else {
            $this->error("请输入正确的手机或者邮箱格式!");
        }

        $errMsg = cmf_check_verification_code($data['username'], $data['verification_code']);
        if (!empty($errMsg)) {
            $this->error($errMsg);
        }

        $userPass = cmf_password($data['password']);
        Db::name("user")->where($userWhere)->update(['user_pass' => $userPass]);

        $this->success("密码重置成功,请使用新密码登录!");

    }
}

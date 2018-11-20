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
use api\device\model\DeviceModel;
use api\admin\model\AppVersionModel;
class PublicController extends RestBaseController
{

    protected $deviceModel;

    public function __construct(DeviceModel $deviceModel)
    {
        parent::__construct();
        $this->deviceModel = $deviceModel;
    }

    // 设备注册
    public function register()
    {
        $validate = new Validate([
            // 'app_name'          => 'require',
            'app_id'            => 'require',
            'version_name'      => 'require',
            'device_name'       => 'require',
            'sn'                => 'require',
            'ip'                => 'require',
            'longitude'         => 'require',
            'latitude'          => 'require',
        ]);

        $validate->message([
            'app_id.require'            => '应用id为空',
            'version_name.require'      => '应用版本号为空',
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
        $findDeviceCount['app_id'] = $data['app_id'];
        $findDeviceCount['status'] = 1;
        $findDeviceCount = Db::name("device")->where($findDeviceWhere)->count();

        if ($findDeviceCount > 0) {
            $this->error("此应用已激活!");
        }

        $is_app = Db::name('app')->where(['id'=>$data['app_id']])->find();
        if(!$is_app){
            $this->error("应用不存在!");
        }

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

        $appVersionModel = new AppVersionModel();
        $appVersionModel->where(['app_id'=>$data['app_id'], 'version_name' => $data['version_name']])->setInc('count');
        $result = $this->deviceModel->save($data);


        if (empty($result)) {
            $this->error("应用激活失败,请重试!");
        }

        $this->success("应用激活成功!");

    }

    // 位置更新
    public function update()
    {
        $validate = new Validate([
            // 'app_name'          => 'require',
            // 'device_name'       => 'require',
            'sn'                => 'require',
            // 'ip'                => 'require',
            'longitude'         => 'require',
            'latitude'          => 'require',
        ]);

        $validate->message([
            // 'app_name.require'          => '应用名为空',
            // 'device_name.require'       => '设备名为空',
            'sn.require'                => '序列号为空',
            // 'ip.require'                => 'ip为空',
            'longitude.require'         => '经度为空',
            'latitude.require'          => '纬度为空',

        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $user = [];

        $findDeviceWhere['sn'] = $data['sn'];
        // $findDeviceCount['app_name'] = $data['app_name'];

        $findDeviceCount = Db::name("device")->where($findDeviceWhere)->count();

        if ($findDeviceCount <= 0) {
            $this->error("此应用不存在!");
        }

        $deviceModel = new DeviceModel();
        $result = $deviceModel->isUpdate(true)->allowField(true)->save($data,['sn'=>$data['sn']]);
        // dump($ip_data);exit();
        // $result = Db::name("device")->where(['sn'=>$data['sn']])->update($data);




        if (empty($result)) {
            $this->error("更新失败!");
        }

        $this->success("更新成功!");

    }
}

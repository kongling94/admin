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
class ListController extends RestBaseController
{

    public function index(){
        // $findDeviceWhere['status'] = 1;
        // $list = Db::name("device")->where($findDeviceWhere)->select();

        $param           = $this->request->param();
        $deviceModel = new DeviceModel();

        $params['where']['status'] = 1;

        $list = $deviceModel->getDatas($param);

        if($list){
            $this->success("获取成功!", ['list'=> $list]);
        }else{
            $this->error("暂无数据!");
        }
    }   
}

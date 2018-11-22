<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace api\admin\controller;

use cmf\controller\RestAdminBaseController;
use think\Db;
use think\Validate;

use api\admin\model\AppModel;
use api\admin\model\LogModel;
class LogController extends RestAdminBaseController
{


    /**
     * 操作记录
     *
     * @return void
     */
    public function index()
    {
        $logModel = new LogModel();
        $list = $logModel->alias('l')->join('__USER__ u', 'l.user_id = u.id')->field('l.id, u.user_login, l.content, l.create_time')->order('l.create_time desc')->limit(10)->select();

        // dump($logModel->getLastSql());
        $this->success('查询成功', ['list' => $list]);
    }


}



















<?php
// +----------------------------------------------------------------------
// | 文件说明：用户表关联model 
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wuwu <15093565100@163.com>
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Date: 2017-7-26
// +----------------------------------------------------------------------
namespace api\admin\model;

use think\Model;
// use api\admin\model\AppVersionModel;
// use api\common\model\CommonModel;
class AppModel extends Model
{
    // protected $type = [
    //     'more' => 'array',
    // ];


    public function getCreateTimeAttr($value){
        if (!empty($value)) {
            $value = date('Y-m-d H:i:s', $value);
        }

        return $value;
    }

    public function getLinkAttr($value){
        if (!empty($value)) {
            $value = cmf_get_domain() . cmf_get_root() . '/conf/' . $value . '.json';
        }

        return $value;
    }

    public function appversion(){
        return $this->hasMany('AppVersionModel', 'app_id', 'id')->field('id, app_id, version_name, create_time, content, file, count')->order('create_time desc');
        // return $this->belongsTo('api\admin\model\AppVersionModel', 'app_id');
    }

    /**
     * 获取应用列表
     *
     * @return void
     */
    public function getlist($app_id = null){
        if($app_id){
            $map['id'] = $app_id;
            $data = $this->with('appversion')->where($map)->field('id, create_time, name, name AS link')->find();
        }else{
            $data = $this->with('appversion')->field('id, create_time, name, name AS link')->order('create_time desc')->select();
        }
        
        // dump($this->getLastSql());
        return $data;
    }
}

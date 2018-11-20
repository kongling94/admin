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
namespace api\device\model;

use think\Model;
use api\common\model\CommonModel;
class DeviceModel extends CommonModel
{
    // protected $type = [
    //     'more' => 'array',
    // ];

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;
    
    // public function appversion(){
    //     return $this->belongsTo('AppVersionModel', 'id', 'id');
    // }

    /**
     * avatar 自动转化
     * @param $value
     * @return string
     */
    public function getCreateTimeAttr($value)
    {
        // return cmf_get_user_avatar_url($value);
        if($value){
            $value = date('Y-m-d H:i:s', $value);
        }
        return $value;
    }


}

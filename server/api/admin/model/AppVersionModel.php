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
// use api\common\model\CommonModel;
class AppVersionModel extends Model
{
    // protected $type = [
    //     'more' => 'array',
    // ];
    
    /**
     * apk地址 自动转化图片地址为绝对地址
     * @param $value
     * @return string
     */
    public function getFileAttr($value)
    {
        if (!empty($value)) {
            $value = cmf_get_image_url($value);
        }

        return $value;
    }

    public function getCreateTimeAttr($value){
        if (!empty($value)) {
            $value = date('Y-m-d H:i:s', $value);
        }

        return $value;
    }

}

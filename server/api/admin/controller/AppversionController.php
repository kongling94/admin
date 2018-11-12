<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace api\admin\controller;

use cmf\controller\RestBaseController;
use think\Db;
use think\Validate;

class AppversionController extends RestBaseController{
    
  public function index(){
     $data = Db::name('app_version')->select();   
     
     $this->success('查询成功',['list' => $data]); 
  }

   public function add(){
     
      $validate = new Validate([
            'name'      => 'require',
            'app_id'    => 'require',
            'content'   => 'require'
        ]);

       $file = $this->request->file('file');
       $info     = $file->validate([
            'ext' => 'jpg,png,apk'
        ]);

       $info = $info->move(ROOT_PATH . 'public' . DS . 'upload');
       $validate->message([
            'name.require'     => '请填写应用名称!',
            'app_id.require'   => '请填写版本号!',
            'content.require'  => '请填写版本说明!'
        ]);

       $data = $this->request->param();
         if (!$validate->check($data)) {
            $this->error($validate->getError());
        }
       
       if($info){
         $saveName     = $info->getSaveName();
         
         Db::name('app_version')->insert([
                'app_id'       => $_POST['app_id'],
                'name'         => $_POST['name'],
                'content'      => $_POST['content'],
                'file'         => $saveName,
                'update_time'  => time(),
                'create_time'  => time()
            ]);
         
         $id = Db::name('app_version')->getLastInsID();

         $this->success('添加成功',['id' => $id]);
       }else{
       	 $this->error($file->getError());
       }
   }

   public function edit(){
     
      
      
   }

   public function del(){
      $id = $_POST['id'];
      if(empty($id)){
      	 $this->error('无效的文章id');
      }
      $data = Db::name('app_version')->where(array('id' => $id))->find();
      
      
      $this->success('删除成功',['list' => $data]);
   }

   public function save(){
      
       
   }


}



















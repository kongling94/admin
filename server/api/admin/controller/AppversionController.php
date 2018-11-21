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

class AppversionController extends RestAdminBaseController
{


    public function index()
    {

        $data = Db::name('app')->select();

        $this->success('查询成功', ['list' => $data]);
    }

    /**
     * 添加应用版本
     *
     * @return void
     */
    public function add()
    {

        $validate = new Validate([
            'name' => 'require',
            'version_name' => 'require',
            'content' => 'require',
            // 'file'          => 'require'
        ]);

        $validate->message([
            'name.require' => '请填写应用名称!',
            'version_name.require' => '请填写版本号!',
            'content.require' => '请填写版本说明!',
            // 'file.require'          => '请上传应用apk'
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $findAppWhere['name'] = $data['name'];

        $findAppCount = Db::name("app")->where($findAppWhere)->count();

        if ($findAppCount > 0) {
            $this->error("应用已存在!");
        }

        $file = $this->request->file('file');
        if(!$file){
            $this->error('请上传应用apk');
        }
        $info = $file->validate([
            'ext' => 'apk,jpg'
        ]);

        $info = $info->move(ROOT_PATH . 'public' . DS . 'upload');


        if ($info) {
            $saveName = $info->getSaveName();

            Db::name('app')->insert([
                'name' => $data['name'],
                'create_time' => time(),
                'update_time' => time()
            ]);

            $appid = Db::name('app')->getLastInsID();

            if ($appid) {
                Db::name('app_version')->insert([
                    'app_id' => $appid,
                    'version_name' => $data['version_name'],
                    'create_time' => time(),
                    'update_time' => time(),
                    'content' => $data['content'],
                    'file' => $saveName
                ]);
            }

            $appModel = new AppModel();
            $result = $appModel->getlist($appid);
            
            file_put_contents(ROOT_PATH . 'public/conf/' .$data['name'].'.json', json_encode($result));

            $this->success('添加成功', ['list'=>$result]);
        } else {
            $this->error($file->getError());
        }
    }

    /**
     * 更新应用版本
     *
     * @return void
     */
    public function update()
    {
        $validate = new Validate([
            'app_id' => 'require',
            'version_name' => 'require',
            'content' => 'require',
            // 'file'          => 'require'
        ]);

        $validate->message([
            'app_id.require' => '应用id为空!',
            'version_name.require' => '请填写版本号!',
            'content.require' => '请填写版本说明!',
            // 'file.require'          => '请上传应用apk'
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $findAppWhere['id'] = $data['app_id'];

        $findAppCount = Db::name("app")->where($findAppWhere)->count();

        if ($findAppCount < 0) {
            $this->error("应用不存在!");
        }

        $file = $this->request->file('file');

        if(!$file){
            $this->error('请上传应用apk');
        }

        $info = $file->validate([
            'ext' => 'apk,jpg'
        ]);

        $info = $info->move(ROOT_PATH . 'public' . DS . 'upload');


        if ($info) {
            $saveName = $info->getSaveName();


            Db::name('app_version')->insert([
                'app_id' => $data['app_id'],
                'version_name' => $data['version_name'],
                'create_time' => time(),
                'update_time' => time(),
                'content' => $data['content'],
                'file' => $saveName
            ]);

            $appModel = new AppModel();
            $result = $appModel->getlist($data['app_id']);
            $json_data['name'] = $result['name'];
            // $json_data['link'] = $result['link'];
            foreach ($result['appversion'] as $key => $value) {
                $json_data['appversion'][$key]['version_name'] = $value['version_name'];
                $json_data['appversion'][$key]['file'] = $value['file'];
                $json_data['appversion'][$key]['content'] = $value['content'];
                $json_data['appversion'][$key]['create_time'] = $value['create_time'];
                
            }
            
            file_put_contents(ROOT_PATH . 'public/conf/' .$result['name'].'.json', json_encode($json_data));

            $this->success('更新成功', ['list'=>$result]);
        } else {
            $this->error($file->getError());
        }


    }

    public function del()
    {
        $id = $_POST['id'];
        if (empty($id)) {
            $this->error('无效的文章id');
        }
        $data = Db::name('app_version')->where(array('id' => $id))->find();


        $this->success('删除成功', ['list' => $data]);
    }

    public function save()
    {


    }


}



















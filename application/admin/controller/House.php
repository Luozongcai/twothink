<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/30 0030
 * Time: 15:56
 */

namespace app\admin\controller;


use kucha\ueditor\Uploader;
use think\Db;

class House extends Admin
{
    //租售信息列表
    public function index(){
        $pid = input('get.pid', 0);
        //删掉过期的消息
        $times=Db::name('house')->select();
        foreach ($times as $v){
            $end=strtotime($v['end_time']);
            if ($end<time()){
                Db::name('house')->where(['id'=>$v['id']])->update(['status'=>3]);
            }
        }

        $list=Db::name('house')->paginate(5);
        $this->assign('pid', $pid);
        $this->assign('list', $list);
        return $this->fetch();
    }

    //修改租售信息
    public function edit($id = 0){
        if($this->request->isPost()){
            $postdata = \think\Request::instance()->post();
            $Channel = \think\Db::name("house");

            $data = $Channel->update($postdata);
            if($data !== false){
                action_log('update_house', 'house', $id, UID);
                $this->success('编辑成功', url('index'));

            } else {
                $this->error('编辑失败');
            }
        } else {

            /* 获取数据 */
            $info = \think\Db::name('house')->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }

            $pid = input('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = \think\Db::name('house')->where(array('id'=>$pid))->find();
                $this->assign('parent', $parent);
            }
            $this->assign('pid', $pid);
            $this->assign('info', $info);
            $this->meta_title = '编辑导航';
            return $this->fetch();
        }
    }
    //删除租售信息
    public function del(){
        $id = array_unique((array)input('id/a',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(\think\Db::name('house')->where($map)->delete()){
            //记录行为
            action_log('update_house', 'house', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    //修改处理状态
    public function status()
    {
        $id = input('id',0);

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $query = Db::name('house')->where(array('id'=>$id))->find();

        if($query['status'] == 1){
            Db::name('house')->where(array('id'=>$id))->update(['status'=>2]);
            $this->success('禁止成功!');
        } elseif($query['status'] == 0||$query['status'] == 2) {
            Db::name('house')->where(array('id'=>$id))->update(['status'=>1]);
            $this->success('启用成功！');
        }else{
            $this->error('消息已经过期！');
        }
    }
    //添加租售信息
    public function add(){
        $file = request()->file('image');
        if(request()->isPost()){
            $Channel = model('house');
            $post_data=\think\Request::instance()->post();
            //自动验证
            $validate = validate('house');
//            var_dump($Channel);die;
            if(!$validate->check($post_data)){
                return $this->error($validate->getError());
            }
            //保存图片路径__PUBLIC__/home/home2/image/tupian/c5c486d6915ebe752a82441e0ea82646.jpg
            $dd="__PUBLIC__/";
                $info = $file->move($dd);
                $name= $info->getFilename();
                 $time=date('Ymd',time());
                $path=__PUBLIC__ . '/tupian/'.$time.'/'.$name;

                $post_data['image']=$path;
                $data = $Channel->create($post_data);

                if($data){
                    $this->success('新增成功', url('index'));
                    //记录行为
                    action_log('update_house', 'house', $data->id, UID);
                } else {
                    $this->error($Channel->getError());
                }
        } else{
            $pid = input('pid', 0);
            //获取父导航
            return $this->fetch('edit');
        }

    }

    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getFilename();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }



}
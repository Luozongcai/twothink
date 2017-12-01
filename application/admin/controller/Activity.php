<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/26 0026
 * Time: 22:32
 */

namespace app\admin\controller;


use think\Db;

class Activity extends Admin
{
    //添加小区消息
    public function add(){

        if(request()->isPost()){
            $Channel = model('activity');
            $post_data=\think\Request::instance()->post();
            //自动验证
            // var_dump($post_data);die;
            $validate = validate('activity');
//            var_dump($Channel);die;
            if(!$validate->check($post_data)){
                return $this->error($validate->getError());
            }

            $data = $Channel->create($post_data);
            if($data){
                $this->success('新增成功', url('index'));
                //记录行为
                action_log('update_activity', 'activity', $data->id, UID);
            } else {
                $this->error($Channel->getError());
            }
        } else {
            $pid = input('pid', 0);
            //获取父导航
            return $this->fetch('edit');
        }

    }
    //列表
    public function index(){
        $pid = input('get.pid', 0);
        //删掉过期的消息
        $times=Db::name('activity')->select();
        foreach ($times as $v){
            $end=strtotime($v['end_time']);
            if ($end<time()){
                Db::name('activity')->where(['id'=>$v['id']])->update(['status'=>3]);
            }
        }

        $list=Db::name('activity')->paginate(5);
        // var_dump($list);die;
        $this->assign('pid', $pid);
        $this->assign('list', $list);
        return $this->fetch();
    }
    //删除
    public function del(){
        $id = array_unique((array)input('id/a',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(\think\Db::name('activity')->where($map)->delete()){
            //记录行为
            action_log('update_activity', 'activity', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
    //修改
    public function edit($id = 0){
        if($this->request->isPost()){
            $postdata = \think\Request::instance()->post();
            //var_dump($postdata);die;
            $Channel = \think\Db::name("activity");

            $data = $Channel->update($postdata);
            if($data !== false){
                action_log('update_activity', 'activity', $id, UID);
                $this->success('编辑成功', url('index'));

            } else {
                $this->error('编辑失败');
            }
        } else {

            /* 获取数据 */
            $info = \think\Db::name('activity')->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }

            $pid = input('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = \think\Db::name('activity')->where(array('id'=>$pid))->find();
                $this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info', $info);
            $this->meta_title = '编辑导航';
            return $this->fetch();
        }
    }
    //修改处理状态
    public function status()
    {
        $id = input('id',0);

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $query = Db::name('activity')->where(array('id'=>$id));

        if($query->find()['status'] == 1){
            $this->success('已经发布了喔!');

        } else {
            Db::name('activity')->where(array('id'=>$id))->update(['status'=>1]);
            $this->success('发布成功！');
        }
    }


    //修改前台关于我们的介绍
    public function myedit($id = 0){
        if($this->request->isPost()){
            $postdata = \think\Request::instance()->post();
            //var_dump($postdata);die;
            $Channel = \think\Db::name("myplot");
            $data = $Channel->update($postdata);
            if($data !== false){
                 $this->success('编辑成功', url('myindex'));

            } else {
                $this->error('编辑失败');
            }
        } else {

            /* 获取数据 */
            $info = \think\Db::name('myplot')->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }

            $pid = input('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = \think\Db::name('myplot')->where(array('id'=>$pid))->find();
                $this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info', $info);
            $this->meta_title = '编辑导航';
            return $this->fetch('');
        }
    }
    //展示关于我们
    public function myindex(){
        $pid = input('get.pid', 0);
        $list=Db::name('myplot')->select();
        $this->assign('pid', $pid);
        $this->assign('list', $list);
        return $this->fetch();
    }





}
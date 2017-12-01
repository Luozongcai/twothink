<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/26 0026
 * Time: 09:16
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;

class Repairs extends Admin
{
    //列表
    public function index(){
        $pid = input('get.pid', 0);
        $list=Db::name('repairs')->paginate(5,true);


        $this->assign('pid', $pid);
        $this->assign('list', $list);
        return $this->fetch();
    }
    //添加
    public function add(){

        if(request()->isPost()){
            $Channel = model('repairs');
            $post_data=\think\Request::instance()->post();
            //自动验证
            $validate = validate('repairs');
            $post_data['sn']=rand(100000,999999);
            $post_data['time']=time();
//            var_dump($Channel);die;
            if(!$validate->check($post_data)){
                return $this->error($validate->getError());
            }

            $data = $Channel->create($post_data);
            if($data){
                $this->success('新增成功', url('index'));
                //记录行为
                action_log('update_repairs', 'repairs', $data->id, UID);
            } else {
                $this->error($Channel->getError());
            }
        } else {
            $pid = input('pid', 0);
            //获取父导航
            return $this->fetch('edit');
        }

    }
    //删除
    public function del(){
        $id = array_unique((array)input('id/a',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(\think\Db::name('repairs')->where($map)->delete()){
            //记录行为
            action_log('update_repairs', 'repairs', $id, UID);
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
            $Channel = \think\Db::name("repairs");
            $data = $Channel->update($postdata);
            if($data !== false){
                action_log('update_repairs', 'repairs', $id, UID);
                $this->success('编辑成功', url('index'));

            } else {
                $this->error('编辑失败');
            }
        } else {

            /* 获取数据 */
            $info = \think\Db::name('repairs')->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }

            $pid = input('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = \think\Db::name('repairs')->where(array('id'=>$pid))->find();
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

        $query = Db::name('repairs')->where(array('id'=>$id));

        if($query->find()['status'] == 1){
            $this->error('物业已处理!');
        }

        if(Db::name('repairs')->where(array('id'=>$id))->update(['status'=>1])){
            //记录行为
            action_log('update_repairs', 'repairs', $id, UID);
            $this->success('处理成功!');
        } else {
            $this->error('处理失败！');
        }
        }




}
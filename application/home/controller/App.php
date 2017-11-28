<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/27 0027
 * Time: 11:35
 */

namespace app\home\controller;


use app\admin\model\Repairs;
use think\Db;


class App extends Home

{
    //添加报修
    public function repairs(){
        if(request()->isPost()){
            $Channel = new Repairs();
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

            return $this->fetch('repairs');
        }
    }
    //小区通知消息展示
    public function notice(){
        //删掉过期的消息
        $times=Db::name('notice')->select();
        foreach ($times as $v){
            $end=strtotime( $v['end_time']);
            if ($end<time()){
                \think\Db::name('notice')->where(['id'=>$v['id']])->delete();
            }
        }

        $list=Db::name('notice')->where(['status'=>1])->paginate(5);
        $this->assign('list', $list);
        return $this->fetch('notice');
    }
    //小区消息详情页
    public function  noticeto($id){
       // $id = \think\Request::instance()->get('id');
        //var_dump($id);die;
        $list=Db::name('notice')->find($id);
        $this->assign('list', $list);
        return $this->fetch('noticeto');
    }
    //便民服务
    public function service(){
        //删掉过期的消息
        $times=Db::name('service')->select();
        foreach ($times as $v){
            $end=strtotime( $v['end_time']);
            if ($end<time()){
                \think\Db::name('service')->where(['id'=>$v['id']])->delete();
            }
        }

        $list=Db::name('service')->where(['status'=>1])->paginate(5);
        $this->assign('list', $list);
        return $this->fetch('service');

}
    //消息详情页
    public function  serviceto($id){

        $list=Db::name('service')->find($id);
        $this->assign('list', $list);
        return $this->fetch('serviceto');
    }
    //小区活动
    public function activity(){
        //删掉过期的消息
        $times=Db::name('activity')->select();
        foreach ($times as $v){
            $end=strtotime( $v['end_time']);
            if ($end<time()){
                \think\Db::name('activity')->where(['id'=>$v['id']])->delete();
            }
        }
        $list=Db::name('activity')->where(['status'=>1])->paginate(5);
        $this->assign('list', $list);
        return $this->fetch('activity');

    }
    //活动详情页
    public function  activityto($id){

        $list=Db::name('activity')->find($id);
        $this->assign('list', $list);
        return $this->fetch('activityto');
    }
    //富文本测试
     public function uedor(){
         return $this->fetch('uedor');
     }

}
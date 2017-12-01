<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/27 0027
 * Time: 11:35
 */

namespace app\home\controller;


use app\admin\model\Repairs;
use app\home\model\Myactivity;
use think\Db;


class App extends Home

{
    //添加报修
    public function repairs(){
        $username=get_username();
        if ($username){
            $is_yezhu= Db::name('ucenter_member')->where(['username'=>$username])->find();
        }
         //登录才能报修
        if (!$username){
            $this->error('您还没有登录，请先登录！', url('user/Login/index'));
        }elseif($is_yezhu['is_owner']==0){
            $this->success('您还没有认证业主,不能保修喔!', url('app/renzheng'));
        }else{
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

                $post_data['login_name']=$username;

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

    }
    //小区通知消息展示
    public function notice(){
        //删掉过期的消息
        $times=Db::name('notice')->select();
        foreach ($times as $v){
            $end=strtotime( $v['end_time']);
            if ($end<time()){
                Db::name('notice')->where(['id'=>$v['id']])->update(['status'=>3]);
               // \think\Db::name('notice')->where(['id'=>$v['id']])->delete();
            }
        }

        $list=Db::name('notice')->where(['status'=>1])->paginate(4);
        $this->assign('list', $list);
        return $this->fetch('notice');
    }
    //AJAX翻页
    public function ajaxnotice($p){
        // 进    行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $list =Db::name('notice')->where(['status'=>1])->page($p.',3')->select();
       $html= '';
        foreach ($list as $v) {
       $html.=' <div class="row noticeList">
            <div class="col-xs-2">
                <img class="noticeImg" src="/public/static/home/home2/image/tupian/'.rand(1,8).'.jpg" />
            </div>
            <div class="col-xs-10">
                <p class="title"><a href="/public/home/app/noticeto?id='.$v['id'].''.$v['title'].'</a></p>
                <p class="info">发布人: '.$v['username'].' &emsp;浏览:'.$v['click'].'<span class="pull-right">'.$v['start_time'].'</span> </p>
            </div>
        </div>';
        }
        return $html;
    }
    //小区消息详情页
    public function  noticeto($id){
       // $id = \think\Request::instance()->get('id');
        //var_dump($id);die;
        $list=Db::name('notice')->find($id);
        $this->assign('list', $list);
        Db::name('notice')->where(['id'=>$id])-> setInc('click', $step = 1, $lazyTime = 0);
        return $this->fetch('noticeto');
    }
    //便民服务
    public function service(){
        //删掉过期的消息
        $times=Db::name('service')->select();
        foreach ($times as $v){
            $end=strtotime( $v['end_time']);
            if ($end<time()){
                Db::name('service')->where(['id'=>$v['id']])->update(['status'=>3]);
            }
        }

        $list=Db::name('service')->where(['status'=>1])->paginate(5);
        $this->assign('list', $list);
        return $this->fetch('service');

}
    //消息详情页
    public function  serviceto($id){

        $list=Db::name('service')->find($id);
        Db::name('service')->where(['id'=>$id])-> setInc('click', $step = 1, $lazyTime = 0);
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
                Db::name('activity')->where(['id'=>$v['id']])->update(['status'=>3]);

            }
        }
        $list=Db::name('activity')->where(['status'=>1])->paginate(5);
        $this->assign('list', $list);
        return $this->fetch('activity');

    }
    //小区活动详情页
    public function  activityto($id){

        $list=Db::name('activity')->find($id);
        Db::name('activity')->where(['id'=>$id])-> setInc('click', $step = 1, $lazyTime = 0);

        $this->assign('list', $list);
        return $this->fetch('activityto');
    }
    // ajax处理用户参加活动
    public function ajaxcome($title){

        $username=get_username();
        if ($username){
            //登录时判断参加没
            $list=Db::name('myactivity')->where(['activity'=>$title,'username'=>$username])->select();
            if (!$list){
                //还没报
                $data['username']=$username;
                $data['activity']=$title;
                $Channel = new Myactivity();
                $Channel->create($data);
                return 'yes';
            }
            else{
                //已经报了名了
                return 'no';
            }

        }else{
            //未登录
           return 'login';
        }

    }
    //商家活动
    public function activity1(){
        //删掉过期的消息
        $times=Db::name('activity')->select();
        foreach ($times as $v){
            $end=strtotime( $v['end_time']);
            if ($end<time()){
                Db::name('activity')->where(['id'=>$v['id']])->update(['status'=>3]);
            }
        }
        $list=Db::name('activity')->where(['status'=>1])->paginate(5);
        $this->assign('list', $list);
        return $this->fetch('activity1');

    }
    //商家活动详情页
    public function  activityto1($id){

        $list=Db::name('activity')->find($id);
            //->setInc();
        Db::name('activity')->where(['id'=>$id])-> setInc('click', $step = 1, $lazyTime = 0);

        $this->assign('list', $list);
        return $this->fetch('activityto1');
    }
    //跳到我的页面my
    public function my(){


        $username=get_username();
        //var_dump($a);die;
        if (!$username){
            $this->error('您还没有登录，请先登录！', url('user/Login/index'));

        }else{

            return $this->fetch('my');
        }


    }
    //我的报修消息
    public function myrepairs(){
        $username=get_username();
        //var_dump($a);die;
        if (!$username){
            $this->error('您还没有登录，请先登录！', url('user/Login/index'));

        }else{
            $list=Db::name('repairs')->where(['login_name'=>$username])->select();
            //->setInc();
            $this->assign('list', $list);
            return $this->fetch('myrepairs');
        }
    }
    //我报名的活动
    public function myactivity(){
        $username=get_username();
        //var_dump($a);die;
        if (!$username){
            $this->error('您还没有登录，请先登录！', url('user/Login/index'));

        }else{
            $list=Db::name('myactivity')->where(['username'=>$username])->select();
            //->setInc();
            $this->assign('list', $list);
            return $this->fetch('myactivity');
        }
    }
    //服务页面
    public function fuwu(){
        return $this->fetch('fuwu');
    }
    //业主认证页面
    public function renzheng(){
        $username=get_username();
        if ($username){
            $is_yezhu= Db::name('ucenter_member')->where(['username'=>$username])->find();
        }
        //var_dump($is_yezhu);die;
        if (!$username){
            //没登录
            $this->error('您还没有登录，请先登录！', url('user/Login/index'));

        }elseif($is_yezhu['is_owner']==1){
            //已经认证过了
            $this->success('您已经认证过了,不需要再认证了', url('app/fuwu'));
        }else{
            //没认证,去认证
            if(request()->isPost()) {
                $post_data = \think\Request::instance()->post();
                //自动验证
                $validate = validate('renzheng');
                if (!$validate->check($post_data)) {
                    return $this->error($validate->getError());
                } else {
                    Db::name('ucenter_member')->where(['username'=>$username])->update(['is_owner'=>1]);
                    $this->success('认证业主成功', url('index'));
                }

            }
            return $this->fetch('renzheng');
        }
    }
    //生活贴士页面
    public function tips(){
        $notice=Db::name('notice')->where(['status'=>1])->select();//小区消息
        $activity=Db::name('activity')->where(['status'=>1])->select();
        $service=Db::name('service')->where(['status'=>1])->select();
        $this->assign('notice', $notice);
        $this->assign('activity', $activity);
        $this->assign('service', $service);
        return $this->fetch('tips');
    }
    //关于我们小区信息页面
    public function myplot(){
        $list=Db::name('myplot')->find();
        $this->assign('list', $list);
        return $this->fetch('myplot');
    }
    //租售页面
    public function zushou(){
        //删掉过期的消息
        $times=Db::name('house')->select();
        foreach ($times as $v){
            $end=strtotime( $v['end_time']);
            if ($end<time()){
                Db::name('house')->where(['id'=>$v['id']])->update(['status'=>3]);
            }
        }

        $chuzu=Db::name('house')->where(['status'=>1,'is_deal'=>0])->select();
        $chushou=Db::name('house')->where(['status'=>1,'is_deal'=>1])->select();
        $this->assign('chuzu', $chuzu);
        $this->assign('chushou', $chushou);
        return $this->fetch('zushou');
    }
    //租售页面详情
    public function zuoshouto($id){
        $list=Db::name('house')->find($id);
        Db::name('house')->where(['id'=>$id])->find();
        $this->assign('list', $list);
        return $this->fetch('zushouto');
    }










    //富文本测试
     public function uedor(){
         return $this->fetch('uedor');
     }

}
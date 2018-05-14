<?php
/**
 * Created by PhpStorm.
 * User: zy350
 * Date: 2018/5/13
 * Time: 12:54
 */
//物业报控制器
namespace app\admin\controller;


use think\Db;

class Repair extends Admin
{
        //物业报修
        public function index(){
                $pid = input('get.pid', 0);
                /* 获取频道列表 */
                $map  = array('status' => array('gt', -1), 'pid'=>$pid);
                $list = \think\Db::name('repair')->select();
                $this->assign('list', $list);
                $this->assign('pid', $pid);
                $this->assign('meta_title' , '导航管理');
                return $this->fetch();

        }

        //报修添加
    public function add(){
        if(request()->isPost()){
            $Repair = model('repair');
            $post_data=\think\Request::instance()->post();
            //自动验证
            $validate = validate('repair');
            if(!$validate->check($post_data)){
                return $this->error($validate->getError());
            }

            $data = $Repair->create($post_data);
            if($data){
                $this->success('新增成功', url('index'));
                //记录行为
//                action_log('update_channel', 'channel', $data->id, UID);
            } else {
                $this->error($Repair->getError());
            }
        } else {
            $pid = input('pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = \think\Db::name('repair')->where(array('id'=>$pid))->field('title')->find();
                $this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info',null);
            $this->assign('meta_title', '新增导航');
            return $this->fetch('edit');
        }
    }

    public function edit($id = 0){
        if($this->request->isPost()){
            $postdata = \think\Request::instance()->post();
            $Repair = \think\Db::name("repair");
            $data = $Repair->update($postdata);
            if($data !== false){
                $this->success('编辑成功', url('index'));
            } else {
                $this->error('编辑失败');
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = \think\Db::name('repair')->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }

            $pid = input('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = \think\Db::name('repair')->where(array('id'=>$pid))->field('title')->find();
                $this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info', $info);
            $this->meta_title = '编辑导航';
            return $this->fetch();
        }
    }

    //物业报修删除
    public function del(){
        $id = array_unique((array)input('id/a',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(\think\Db::name('repair')->where($map)->delete()){
            //记录行为
//            action_log('update_channel', 'channel', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

}
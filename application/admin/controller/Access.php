<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/6
 * Time: 16:42
 */

namespace app\admin\controller;


class Access extends Admin
{
    protected $Group; //用户分组
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->Group = model('Group');
    }

    /**
     * 获取分组列表
     */
    public function group()
    {
         $group = $this->Group->select()->toArray();

         int_to_string($group, array('status' => array(1 => '启用', 0 => '禁用')));

         $this->assign('list', $group);
         $this->setMeta('角色列表');
         return view('group');
         var_dump($group);die();
    }

    /**
     * 添加角色组
     * @return \think\response\View|void
     */
    public function addGroup()
    {
        if (IS_POST) {
            $data = input('post.');
            unset($data['id']);
            $data['module'] = 'admin';
            $id = $this->Group->save($data);
            if ($id) {
                return $this->success('新增成功', 'access/group');
            } else {
                return $this->error('新增失败');
            }
        } else {

            $this->assign('info', array());
            $this->setMeta('新增角色');
            return view('edit_group');
        }

    }

    /**
     * 修改角色组信息
     * @param int $id
     * @return \think\response\View|void
     */
    public function editGroup($id = 0)
    {
        if (IS_POST) {
            $data = input('post.');

            $res = $this->Group->save($data, array('id' => $data['id']));
            if ($res) {
                return $this->success('更新成功', 'access/group');
            } else {
                return $this->error('更新失败');
            }
        } else {
            if (empty($id)) {
                return $this->error('请选择要操作的数据!');
            }

            /* 获取数据 */
            $info  = $this->Group->get($id)->toArray();
            if (!$info) {
                return $this->error('参数错误');
            }

            $this->assign('info', $info);
            $this->setMeta('编辑角色');
            return view('edit_group');
        }
    }




}
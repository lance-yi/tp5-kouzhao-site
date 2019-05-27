<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/16
 * Time: 17:12
 */

namespace app\admin\controller;
use app\admin\model\InfoModel;

class Option extends Index
{
    public function __construct()
    {
        parent::__construct();

    }

    public function param()
    {
        $this->checkLogin();
        $info = InfoModel::get(1)->toArray();
        return view('param',['data'=>$info]);
    }

    public function updateCopy()
    {
        $this->checkLogin();
        $data = [
            'phone' => input('post.phone'),
            'code' => input('post.code'),
            'datetime' => time(),
        ];

        $info = new InfoModel();

        $info->save($data,['id' => 1]);
        if ($info) {
            $this->success('修改成功!');
        } else {
            $this->error('修改失败!');
        }
    }
}
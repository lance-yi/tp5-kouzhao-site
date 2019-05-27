<?php

namespace app\index\controller;

use app\admin\model\GuestbookModel;
use app\admin\model\InfoModel;
use think\Controller;

class Index extends Controller
{
    protected $keyword;
    protected $plan;
    protected $unit;

    public function __construct()
    {
        parent::__construct();
        $keyword = isset($_GET['keyword']) ? clean(trim($_GET['keyword'])) : "";
        $plan = isset($_GET['plan']) ? clean(trim($_GET['plan'])) : "";
        $unit = isset($_GET['unit']) ? clean(trim($_GET['unit'])) : "";
        cookie('keyword', $keyword);
        cookie('plan', $plan);
        cookie('unit', $unit);

        $this->keyword = cookie('keyword');
        $this->plan = cookie('plan');
        $this->unit = cookie('unit');
    }

    public function index()
    {
        $info = InfoModel::get(1);
        $phone = $info["phone"];
        $code = $info["code"];
        $array = [
            'phone' => $phone,
            'code' => htmlspecialchars_decode(html_entity_decode($code)),
            'keyword' => $this->keyword,
            'plan' => $this->plan,
            'unit' => $this->unit,
        ];
        return view('', $array);
    }

    // 添加留言
    public function adds()
    {
        $name1 = clean(trim(input('name')));
        //留言者姓名
        $name = $name1;
        //手机
        $mobile = clean(trim(input('mobile')));
        //留言者ip
        $mip = get_client_ip(0);
        //标示
        $keyword = clean(trim(cookie('keyword')));
        $plan = clean(trim(cookie('plan')));
        $unit = clean(trim(cookie('unit')));
        $froms = 'plan=' . $plan . '&unit=' . $unit . '&keyword=' . $keyword;
        if (empty($plan)) {
            $plan = 'none';
        }
        if (empty($unit)) {
            $unit = 'none';
        }
        if (empty($keyword)) {
            $from = 'none';
        }
        //编辑日期
        $updatetime = time();
        //留言日期
        $dateline = time();
        $checkName = is_name($name1);
        $checkMobile = is_mobile($mobile);
        if (!$checkName) {
            echo "
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
			<script>alert('姓名为2~4个汉字');history.back(-1);</script>";
            return false;
        }
        if (!$checkMobile) {
            echo "
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
			<script>alert('请正确填写手机');history.back(-1);</script>";
            return false;
        }
        if ($_POST) {
            if ($checkName && $checkMobile) {
                $guestbook = new GuestbookModel();
                $condition["name"] = $name;
                $condition["phone"] = $mobile;
                $result = $guestbook->where($condition)->find();
                if ($result) {
                    echo "<script>alert('提交过于频繁，请稍后再试!!');history.back(-1);</script>";
                } else {
                    $data = [
                        'name' => $name,
                        'phone' => $mobile,
                        'is_read' => 0,
                        'diqu' => $froms,
                        'mip' => $mip,
                        'create_time' => $dateline,
                    ];
                    $guestbook->insert($data);
                    if ($data) {
                        echo "<script>alert('提交成功!');history.back(-1);</script>";
                    } else {
                        echo "<script>alert('提交失败!');history.back(-1);</script>";
                    }
                }
            }
        }
    }
}

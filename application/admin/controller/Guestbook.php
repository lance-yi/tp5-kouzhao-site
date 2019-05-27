<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/16
 * Time: 17:41
 */

namespace app\admin\controller;


use app\admin\model\GuestbookModel;

class Guestbook extends Index
{
    protected $result;
    protected $page;
    protected $count;

    public function __construct()
    {
        parent::__construct();
    }

    // 列表渲染
    public function initGuestbookList()
    {
        $this->checkLogin();
        $fromtime = isset($_GET['fromtime']) ? strtotime($_GET['fromtime']) : ''; // 开始时间
        $totime = isset($_GET['totime']) ? strtotime($_GET['totime']) : ''; // 结束时间
        $field = isset($_GET['field']) ? $_GET['field'] : '';  // 类型
        $q = isset($_GET['q']) ? $_GET["q"] : '';

        $guestbook = new GuestbookModel();
        switch ($field) {
            case "num":
                $this->result = $guestbook
                    ->where('is_read', 0)
                    ->where('create_time', ['>=', $fromtime], ['<=', $totime], 'and')
                    ->order('create_time desc')
                    ->paginate(20);
                $this->count = $guestbook
                    ->where('is_read', 0)
                    ->where('create_time', ['>=', $fromtime], ['<=', $totime], 'and')
                    ->order('create_time desc')
                    ->count();
                $this->page = $this->result->render();
                break;
            case "gid":
                $this->result = $guestbook
                    ->where('id', $q)
                    ->where('is_read', 0)
                    ->where('create_time', ['>=', $fromtime], ['<=', $totime], 'and')
                    ->order('create_time desc')
                    ->paginate(20);
                $this->count = $guestbook
                    ->where('id', $q)
                    ->where('is_read', 0)
                    ->where('create_time', ['>=', $fromtime], ['<=', $totime], 'and')
                    ->order('create_time desc')
                    ->count();
                $this->page = $this->result->render();
                break;
            case "site":
                $this->result = $guestbook
                    ->where('diqu', 'like', '%' . $q . '%')
                    ->where('is_read', 0)
                    ->where('create_time', ['>=', $fromtime], ['<=', $totime], 'and')
                    ->order('create_time desc')
                    ->paginate(20);
                $this->count = $guestbook
                    ->where('diqu', 'like', '%' . $q . '%')
                    ->where('is_read', 0)
                    ->where('create_time', ['>=', $fromtime], ['<=', $totime], 'and')
                    ->order('create_time desc')
                    ->count();
                $this->page = $this->result->render();
                break;
            case "name":
                $this->result = $guestbook
                    ->where('name', 'like', '%' . $q . '%')
                    ->where('is_read', 0)
                    ->where('create_time', ['>=', $fromtime], ['<=', $totime], 'and')
                    ->order('create_time desc')
                    ->paginate(20);
                $this->count = $guestbook
                    ->where('name', 'like', '%' . $q . '%')
                    ->where('is_read', 0)
                    ->where('create_time', ['>=', $fromtime], ['<=', $totime], 'and')
                    ->order('create_time desc')
                    ->count();
                $this->page = $this->result->render();
                break;
            case "phone":
                $this->result = $guestbook
                    ->where('phone', 'like', '%' . $q . '%')
                    ->where('is_read', 0)
                    ->where('create_time', ['>=', $fromtime], ['<=', $totime], 'and')
                    ->order('create_time desc')
                    ->paginate(20);
                $this->count = $guestbook
                    ->where('phone', 'like', '%' . $q . '%')
                    ->where('is_read', 0)
                    ->where('create_time', ['>=', $fromtime], ['<=', $totime], 'and')
                    ->order('create_time desc')
                    ->count();
                $this->page = $this->result->render();
                break;
            default:
                $this->result = $guestbook->where('is_read', 0)->order('create_time desc')->paginate(20);
                $this->count = $guestbook->where('is_read', 0)->order('create_time desc')->count();
                $this->page = $this->result->render();
        };
        $time = time();
        $data = [
            'list' => $this->result,
            "page" => $this->page,
            "count" => $this->count,
            'time' => $time
        ];
        return view('initGuestbookList', $data);
    }

    // 删除
    public function delete()
    {
        $this->checkLogin();
        $data = input('post.id/a');
        if (is_array(input('post.id/a'))) {
            for ($i = 0; $i < count($data); $i++) {
                $guestData = [
                    'id' => (int)$data[$i],
                    'is_read' => 1
                ];
                GuestbookModel::update($guestData);
            }
            echo true;
//            $id = implode(',',input('post.id/a'));
        } else {
            echo false;
//            $id = substr(input('post.id/a'),0,-1);
        }
    }

    // 查看
    public function initReadGuestbook()
    {
        $this->checkLogin();
        $id = input('get.id');
        $guestbook = GuestbookModel::get(['id' => $id]);
        $array = [
            'guestbooks' => $guestbook
        ];
        return view('initReadGuestbook', $array);
    }

    // 导出渲染
    public function initexportList()
    {
        $this->checkLogin();
        $time = time();
        $array = [
            'time' => $time
        ];
        return view('initexportList', $array);
    }

    // 导出
    public function exportGuest()
    {
        $this->checkLogin();
        $fromtime = strtotime($_GET['fromtime']);
        $totime = strtotime($_GET['totime']);
        $guestbookModel = new GuestbookModel();
        $data = $guestbookModel
            ->field('id,name,phone,diqu,create_time')
            ->where('create_time', ['>=', $fromtime], ['<=', $totime], 'and')
            ->order('create_time desc')
            ->select();
        foreach ($data as &$val) {
            $val['create_time'] = date('Y-m-d H:i:s', $val['create_time']);
        }
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");
        $headArr = array("id", "姓名", "电话", "标识", "留言时间");
        $this->getExcel($data);
        $this->success();
    }

    private function getExcel($data)
    {
        //1.从数据库中取出数据
        //对数据进行检验
        if (empty($data) || !is_array($data)) {
            $this->error("没有符合条件的数据可导出!");
        }
        //2.加载PHPExcle类库
        vendor('PHPExcel.PHPExcel'); // 此为插件模式
        //3.实例化PHPExcel类
        $objPHPExcel = new \PHPExcel();
        //4.激活当前的sheet表
        $objPHPExcel->setActiveSheetIndex(0);
        //5.设置表格头（即excel表格的第一行）
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '姓名')
            ->setCellValue('C1', '电话')
            ->setCellValue('D1', '标识')
            ->setCellValue('E1', '留言时间');
        //设置F列水平居中
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //设置单元格宽度
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(30);
        //6.循环刚取出来的数组，将数据逐一添加到excel表格。
        for($i=0;$i<count($data);$i++){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2),$data[$i]['id']);//添加ID
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2),$data[$i]['name']);//添加姓名
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2),$data[$i]['phone']);//添加电话
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2),$data[$i]['diqu']);// 添加标识
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2),$data[$i]['create_time']);//添加留言时间
        }
        //7.设置保存的Excel表格名称
        $filename = '客服留言表'.date('ymd',time()).'.xls';
        //8.设置当前激活的sheet表格名称；
        $objPHPExcel->getActiveSheet()->setTitle('客服留言表');
        //9.设置浏览器窗口下载表格
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$filename.'"');
        //生成excel文件
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //下载文件在浏览器窗口
        $objWriter->save('php://output');
        exit;
    }
}
<?php
namespace app\index\controller;
use think\Controller;
use think\Db;//引入数据库
class Excel extends Controller
{
    public function save(){

            vendor("PHPExcel.PHPExcel");
            $objPHPExcel =new \PHPExcel();
            //获取表单上传文件
            $file = request()->file('excel');
            $info = $file->validate(['ext' => 'xlsx'])->move(ROOT_PATH . 'public');  //上传验证后缀名,以及上传之后移动的地址  E:\wamp\www\bick\public
            if($info)
            {
//              echo $info->getFilename();
                $exclePath = $info->getSaveName();  //获取文件名
                $file_name = ROOT_PATH . 'public' . DS . $exclePath;//上传文件的地址
                $objReader =\PHPExcel_IOFactory::createReader("Excel2007");
                $obj_PHPExcel =$objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8
                $excel_array=$obj_PHPExcel->getSheet(0)->toArray();   //转换为数组格式
                array_shift($excel_array);  //删除第一个数组(标题);
                $city = [];
                $i=0;
                foreach($excel_array as $k=>$v) {
                    $city[$k]['name'] = $v[0];
                    $city[$k]['code'] = $v[1];
                    $i++;
                }
                Db::name("area_code")->insertAll($city);
            }else
            {
                echo $file->getError();
            }
    }
    public function r(){
        return $this->fetch('upload');
    }



}
<?php
namespace  app\admin\controller;
use app\common\controller\Backend;
use think\Db;
class Upload extends Backend{
    public function upload_file()
    {
        if (($_FILES["file"]["type"] == "image/png" || $_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "video/mp4") && $_FILES["file"]["size"] < 1024000000) {
            $filename = "/uploads/" . input('name') . "/" . time() . $_FILES["file"]["name"];
            //转码，把utf-8转成gb2312,返回转换后的字符串， 或者在失败时返回 FALSE。
            $filename = iconv("UTF-8", "gb2312", $filename);
            //检查文件或目录是否存在
            if (file_exists($filename)) {
                return ['staus' => 'err', 'data' => '', 'msg' => '该文件已存在'];
            } else {
                //保存文件,   move_uploaded_file 将上传的文件移动到新位置
                move_uploaded_file($_FILES["file"]["tmp_name"], ROOT_PATH.'/public'.$filename);//将临时地址移动到指定地址
                return ['staus' => 'succ', 'data' => $filename, 'msg' => '文件上传成功'];
            }
        }else {
                return ['staus' => 'err', 'data' => '', 'msg' => '文件类型错误或文件过大'];
            }
    }
}
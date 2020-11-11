<?php
namespace app\admin\controller\question;
use app\common\controller\Backend;
use app\common\library\Auth;
use think\db;
use app\admin\model\Question as Qs;
use app\admin\controller\Category as Cate;
use app\admin\controller\user\User as User;
class Manage extends Backend
{
    public function _initialize()
    {
        parent::_initialize();
    }
    public function index(){
        $get_meu=['id','cid','title','type','set_time','select_type','is_show','analysis'];
       $row=Qs::question_data('selectall',$get_meu);
       if($row=='text'){
           $this->error($row['msg']);
       }
       $this->assign('data',$row['data']);
       return view();
    }
    public function add(){
        if($this->request->isPost()){
            $file = $this->request->file('excel');
            if(input('post.cid')==''||$file==''){
                $this->error('缺少必要选项');
            }
            vendor("phpexecl.PHPExcel");
            $objPHPExcel =new \PHPExcel();
            $info = $file->validate(['ext' => 'xlsx'])->move(ROOT_PATH . 'public');  //上传验证后缀名,以及上传之后移动的地址  E:\wamp\www\bick\public
            if($info)
            {
                $exclePath = $info->getSaveName();  //获取文件名
                $file_name = ROOT_PATH . 'public' . DS . $exclePath;//上传文件的地址
                $objReader =\PHPExcel_IOFactory::createReader("Excel2007");
                $obj_PHPExcel =$objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8
                $excel_array=$obj_PHPExcel->getSheet(0)->toArray();   //转换为数组格式
                array_shift($excel_array);  //删除第一个数组(标题);
                $city = [];
                $i=0;
                foreach($excel_array as $k=>$v) {
                if($v[0]==null){
                     break;
                    }
                        $city['title'] = $v[0];
                        $city['cid'] = input('post.cid');
                        $city['time'] = time();
                        $city['type'] = $v[1];
                        $city['set_time'] = $v[2];
                        $city['select_type'] = $v[3];
                        $city['is_show'] = $v[4];
                        $city['analysis'] = $v[5];
                        $id=Db::name("qsbank")->insertGetId($city);
                        $this->add_answer($id,$v[6]);
                        $i++;
                }
                $this->success('导入完成');
            }else
            {
                echo $file->getError();
            }
        }
        $category_data=$this->get_all_categorytree();
        $this->assign('category_data',$category_data);
        return view();
     }

    public function edit($ids = null){
        if($this->request->isPost()){
          $data=input('post.');
          if($data['answer']){
                //选项更新
              $update_ans_res=Qs::update_answers($data['id'],$data['answer']);
              unset($data['answer']);
          }
          $where['id']=$data['id'];
          unset($data['id']);

           $update_result=Qs::question_data('update',$where,null,null,null,$data);
          if($update_result['data']=='succ'){
              $this->success($update_result['msg']);
          }
        }
        $where=['id'=>input('get.id')];
        $get_meu=['id','cid','title','type','set_time','select_type','is_show','analysis'];
        $row=Qs::question_data('select',$where,$get_meu);
        $category_data=$this->get_all_categorytree();
        /*当前题目下的选项*/
       /* $answe=Qs::get_qestion_ans(input('get.id'));*/
        $res=Db::name('answer')->where('qsb_id',input('get.id'))->select();
        $this->assign('answe',$res);
        $this->assign('data',$row['data']);
        $this->assign('category_data',$category_data);
        return view();
    }

    public function get_all_categorytree(){
         $cate=Db::name('category')->select();
         $catelist=$this->getCategory($cate);
         return $catelist;
    }
    /**
     * 获取分类树
     * @param array $array 数据源
     * @param int $pid 父级ID
     * @param int $level 分类级别
     * @return string
     */
    public function getCategory($array, $pid =0, $level = 0){
        //声明静态数组,避免递归调用时,多次声明导致数组覆盖
        static $list = [];
        foreach ($array as $key => $value){
            //第一次遍历,找到父节点为根节点的节点 也就是pid=0的节点
            if ($value['pid'] == $pid){
                //父节点为根节点的节点,级别为0，也就是第一级
                $value['level'] = $level;
                //把数组放到list中
                $list[] = $value;
                //把这个节点从数组中移除,减少后续递归消耗
                unset($array[$key]);
                //开始递归,查找父ID为该节点ID的节点,级别则为原级别+1
                $this->getCategory($array, $value['id'], $level+1);
            }
        }
        return $list;
    }
     //
    //带*为正确答案
    //$string  字符串
    public function add_answer($qsb_id,$string){

        $ans_type=[];
        $ans = explode('；',$string);
       foreach ($ans as $k=>$v){
           if(empty($v)){
                  unset($ans[$k]);
                  break;
           }
           $ans_type['qsb_id']=$qsb_id;
           $ans_type['time']=time();
           $str=substr( $v, 0, 1 );
           if ($str=="*") {
               $ans_type['is_true']=1;
               $ans_type['content']=substr($v,1);
           }else{
               $ans_type['is_true']=0;
               $ans_type['content']=$v;
           }
           Db::name("answer")->insert($ans_type);
       }
        return true;
    }
    function getFirstCharter($str){
        if(empty($str)){return '';}
        if(is_numeric($str{0})) return $str{0};// 如果是数字开头 则返回数字
        $fchar=ord($str{0});
        if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0}); //如果是字母则返回字母的大写
        $s1=iconv('UTF-8','gb2312',$str);
        $s2=iconv('gb2312','UTF-8',$s1);
        $s=$s2==$str?$s1:$str;
        $asc=ord($s{0})*256+ord($s{1})-65536;
        if($asc>=-20319&&$asc<=-20284) return 'A';//这些都是汉字
        if($asc>=-20283&&$asc<=-19776) return 'B';
        if($asc>=-19775&&$asc<=-19219) return 'C';
        if($asc>=-19218&&$asc<=-18711) return 'D';
        if($asc>=-18710&&$asc<=-18527) return 'E';
        if($asc>=-18526&&$asc<=-18240) return 'F';
        if($asc>=-18239&&$asc<=-17923) return 'G';
        if($asc>=-17922&&$asc<=-17418) return 'H';
        if($asc>=-17417&&$asc<=-16475) return 'J';
        if($asc>=-16474&&$asc<=-16213) return 'K';
        if($asc>=-16212&&$asc<=-15641) return 'L';
        if($asc>=-15640&&$asc<=-15166) return 'M';
        if($asc>=-15165&&$asc<=-14923) return 'N';
        if($asc>=-14922&&$asc<=-14915) return 'O';
        if($asc>=-14914&&$asc<=-14631) return 'P';
        if($asc>=-14630&&$asc<=-14150) return 'Q';
        if($asc>=-14149&&$asc<=-14091) return 'R';
        if($asc>=-14090&&$asc<=-13319) return 'S';
        if($asc>=-13318&&$asc<=-12839) return 'T';
        if($asc>=-12838&&$asc<=-12557) return 'W';
        if($asc>=-12556&&$asc<=-11848) return 'X';
        if($asc>=-11847&&$asc<=-11056) return 'Y';
        if($asc>=-11055&&$asc<=-10247) return 'Z';
        return null;
    }
    public function del($ids = ''){
     $data=input('post.');
     $del_data=Qs::question_data('del',['id'=>$data['id']]);
        return $del_data;
    }
    public function del_all($ids = ''){
        $data=input('post.');

        foreach ($data['id'] as $k=>$v){
            $del_data[$k]=$v;
        }
        $del_datas=Db::name('qsbank')->delete($del_data);
        if($del_datas){
            return ['msg'=>'删除完成'];
        }
    }
    public function sreach(){
        $begin_time=input('post.begin_time');
        $end_time=input('post.end_time');
        $key_word=input('post.key_word');
        $get_field=['id','cid','title','type','set_time','select_type','is_show','analysis','time'];;
        $user=new User();
        $res=$user->sreach_datas($begin_time,$end_time,$key_word,$get_field,'qsbank');
        $this->assign('data',$res);
        return $this -> fetch('index');
    }
}
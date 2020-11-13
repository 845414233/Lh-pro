<?php
namespace app\api\model;
use app\common\model\MoneyLog;
use app\common\model\ScoreLog;
use think\Model;
use think\db;

class Common extends Model
{

    // 表名
     public $name;
     public $info;

  public function _initialize(){
        $this->name='user';
        $this->info="user_info";
  }
    public  function user_data($row,$where=[],$toarray=[],$order="id asc",$inser_qestion=[],$update_qestion=[]){
        switch ($row)
        {
            case 'selectall':
                $res=$this->get_user_alldata($toarray,$order);
                break;
            case 'select':
                $res=$this->get_user_data($where,$toarray,$order);
                break;
            case 'select_nop':
                $res=$this->get_user_data_nop($where,$toarray,$order);
                break;
            case 'insert':
                $res=$this->insert_user_data($inser_qestion);
                break;
            case 'insert_info':
                $res=$this->insert_user_info($inser_qestion);
                break;
            case 'update':
                $res=$this->update_user_data($where,$update_qestion);
                break;
            case 'del':
                $res=$this->del_user_data($where);
                break;
            default:
                return ['type'=>'text','data'=>'err','msg'=>'请求错误'];
        }
        return $res;
    }
    /*
    * 获取选定用户
    * $toarray:要查询的字段
    * $order:排序规则
    * */
    public function get_user_data($where,$toarray,$order){
        $newstr=$this->string_tofield($toarray);
        $row=Db::name($this->name)
            ->where($where)
            ->order($order)
            ->field($newstr)
            ->paginate(20);
        return  ['type'=>'array','data'=>$row,'msg'=>'查询成功'];
    }
    /*
     * 获取选定用户
     * $toarray:要查询的字段
     * $order:排序规则
     * */
    public function get_user_data_nop($where,$toarray,$order){
        $newstr=$this->string_tofield($toarray);
        $row=Db::name($this->name)
            ->where($where)
            ->order($order)
            ->field($newstr)
            ->select();
        return  ['type'=>'array','data'=>$row,'msg'=>'查询成功'];
    }
    /*
     *
     * 获取全部用户
     * $toarray:要查询的字段
     * $order:排序规则
     * */
    public  function  get_user_alldata($toarray,$order){
        $newstr=$this->string_tofield($toarray);
        $row=Db::name($this->name)
            ->order($order)
            ->field($newstr)
            ->paginate(20);
         return  ['type'=>'array','data'=>$row,'msg'=>'查询成功'];
   }
   public function insert_user_data($inset_user){
       $row= Db::name($this->name)
           ->insertGetId($inset_user);
       if($row){
           return ['type'=>'text','data'=>$row,'msg'=>'添加成功'];
       }else{
           return ['type'=>'text','data'=>'err','msg'=>'添加失败'];
       }
   }
   public function insert_user_info($inser_qestion){
       $row= Db::name('user_info')
             ->insert($inser_qestion);
       if($row){
           return ['type'=>'text','data'=>$row,'msg'=>'添加成功'];
       }else{
           return ['type'=>'text','data'=>'err','msg'=>'添加失败'];

       }
   }

   public function update_user_data($where,$update_qestion){
       if(!$where ||!$update_qestion){
           return ['type'=>'text','data'=>'err','msg'=>'缺少条件语句'];
       }
       $row= Db::name($this->name)
           ->where($where)
           ->setField($update_qestion);
       if($row){
           return ['type'=>'text','data'=>'succ','msg'=>'更改成功'];
       }else{
           return ['type'=>'text','data'=>'err','msg'=>"更新失败"];
       }
   }
   public function del_user_data($where){
       if(!$where){
           return ['type'=>'text','data'=>'err','msg'=>'缺少条件语句'];
       }
      /* dump($where);
       die;*/
       $row= Db::name($this->name)
           ->where($where)
           ->delete();
       if($row){
           return ['type'=>'text','data'=>'succ','msg'=>'删除成功'];
       }else{
           return ['type'=>'text','data'=>'err','msg'=>'删除失败'];
       }
   }
   public function check_user_data($data=[])
   {
       foreach($data as $k=>$v){
           $res=Db::name($this->name)->where($k,$v)->find();
       }
          return $res;
   }
    /*字段转换*/
    public  function string_tofield($toarray){
        $string='';
        foreach($toarray as $k=>$v){
            $string.=$v.',';
        }
        $newstr = substr($string,0,strlen($string)-1);
        return $newstr;
    }
    public function string_to_simplify($data){
        foreach($data as $k=>$v){
            dump($v);
        }
    }
}

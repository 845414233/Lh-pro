<?php
namespace app\admin\model;
use think\model;
use think\db;
use Exception;
use think\exception\Handle;
use think\exception\HttpException;
class Question extends Model
{
      public  $name='qsbank';
     /*
      *$row  操作类型
      *$where 条件语句
      *$toarray 获取的字段
      * $order 排序
      * $inser_qestion 添加语句
      * 操作入口
     */
      static function question_data($row,$where=[],$toarray=[],$order="id asc",$inser_qestion=[],$update_qestion=[]){
         switch ($row)
         {
             case 'selectall':
                 $res=self::get_question_alldata($toarray,$order);
                 break;
             case 'select':

           $res=self::get_question_data($where,$toarray,$order);
        break;
             case 'insert':
            $res=self::insert_question_data($inser_qestion);
          break;
             case 'update':
                 $res=self::update_question_data($where,$update_qestion);
                 break;
             case 'del':
                 $res=self::del_question_data($where);
                 break;
             default:
                 return ['type'=>'text','data'=>'err','msg'=>'请求错误'];
         }
         return $res;
     }
    /*
    * $where:条件语句
    * $toarray：获取的字段
    * */
    protected static function get_question_data($where=[],$toarray=[],$order){
          $newstr=self::string_tofield($toarray);
        $row= Db::name('qsbank')
            ->where($where)
            ->order($order)
            ->field($newstr)
            ->paginate(20);
        return ['type'=>'array','data'=>$row,'msg'=>'查询成功'];
    }
    /*字段转换*/
    public static function string_tofield($toarray){
        $string='';
        foreach($toarray as $k=>$v){
            $string.=$v.',';
        }
        $newstr = substr($string,0,strlen($string)-1);
        return $newstr;
    }

     /*
      * $where:条件语句
      * $toarray：获取的字段
      * */
     protected static function get_question_alldata($toarray=[],$order){
         $newstr=self::string_tofield($toarray);
         $row= Db::name('qsbank')
             ->order($order)
            ->field($newstr)
             ->paginate(20);
         return ['type'=>'array','data'=>$row,'msg'=>'查询成功'];
     }
    /*
   * $where:条件语句
   * $toarray：获取的字段
   * */
    protected static function insert_question_data($inser_qestion){
        $row= Db::name('qsbank')
            ->insert($inser_qestion);
        if($row){
            return ['type'=>'text','data'=>'succ','msg'=>'添加成功'];
        }else{
            return ['type'=>'text','data'=>'err','msg'=>$e->getMessage()];

        }
    }
    /*
 * $where:条件语句
 * $toarray：要更改的字段
 * */
    static function update_question_data($where,$update_qestion){
        if(!$where ||!$update_qestion){
            return ['type'=>'text','data'=>'err','msg'=>'缺少条件语句'];
        }
        $row= Db::name('qsbank')
            ->where($where)
            ->setField($update_qestion);
        if($row){
            return ['type'=>'text','data'=>'succ','msg'=>'更改成功'];
        }else{
            return ['type'=>'text','data'=>'err','msg'=>"更新失败"];
        }
    }
    /*
* $where:条件语句
* $toarray：获取的字段
* */
    protected static function del_question_data($where){
        if(!$where){
            return ['type'=>'text','data'=>'err','msg'=>'缺少条件语句'];
        }
        $row= Db::name('qsbank')
            ->where($where)
            ->delete();
        if($row){
            return ['type'=>'text','data'=>'succ','msg'=>'删除成功'];
        }else{
            return ['type'=>'text','data'=>'err','msg'=>$e->getMessage()];
        }
    }
    /*
     * $id是题目id
     * $is_true :该题目下正确选项
     * */
    public static function update_answers($id,$is_true=[]){
       $row=Db::name('answer')->where('qsb_id',$id)->select();
   foreach ($row as $k=>$v){
             Db::name('answer')->where('id',$v['id'])->setField(['is_true'=>0]);
      }
      foreach($is_true as $k=>$v){
      Db::name('answer')->where('id',$k)->setField(['is_true'=>1]);
      }
    }
}
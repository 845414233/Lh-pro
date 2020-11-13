<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:76:"D:\wwwroot\wap.pro.com\public/../application/admin\view\user\user\index.html";i:1605077268;s:65:"D:\wwwroot\wap.pro.com\application\admin\view\layout\default.html";i:1602168706;s:62:"D:\wwwroot\wap.pro.com\application\admin\view\common\meta.html";i:1602168706;s:64:"D:\wwwroot\wap.pro.com\application\admin\view\common\script.html";i:1602168706;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<meta name="referrer" content="never">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<?php if(\think\Config::get('fastadmin.adminskin')): ?>
<link href="/assets/css/skins/<?php echo \think\Config::get('fastadmin.adminskin'); ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
<?php endif; ?>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>

    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !\think\Config::get('fastadmin.multiplenav') && \think\Config::get('fastadmin.breadcrumb')): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <?php if($auth->check('dashboard')): ?>
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                    <?php endif; ?>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="stylesheet" href="/assets/admin/css/font.css">
        <link rel="stylesheet" href="/assets/admin/css/xadmin.css">
        <script src="/assets/admin/lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="/assets/admin/js/xadmin.js"></script>
        <!--[if lt IE 9]>
          <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
          <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="<?php echo url('index/index'); ?>">首页</a>
            <a href="<?php echo url('user/user/index'); ?>">会员管理</a>
            <a>
              <cite>导航元素</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form class="layui-form layui-col-space5" style="margin-bottom: 10px;" id="sreach" action="<?php echo url('user/user/sreach'); ?>" method="post">
                                <div class="layui-inline layui-show-xs-block">
                                    <input class="layui-input"  autocomplete="off" placeholder="开始日" name="begin_time" id="start">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input class="layui-input"  autocomplete="off" placeholder="截止日" name="end_time" id="end">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input type="text" name="key_word"  placeholder="请输入手机号" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">

                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                            <button class="layui-btn" onclick="xadmin.open('添加用户','<?php echo url('user/user/add'); ?>',600,400)"><i class="layui-icon"></i>添加用户</button>

                        </div>
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                              <thead>
                                <tr>
                                  <th>
                                   <!-- <input type="checkbox" name=""  lay-skin="primary">-->
                                  </th>
                                  <th>ID</th>
                                  <th>上级ID</th>
                                  <th>手机号</th>
                                  <th>用户名</th>
                                  <th>注册时间</th>
                                  <th>学校</th>
                                  <th>专业</th>
                                  <th>剩余vip时间</th>
                                  <th>是否拥有分享资格</th>
                                  <th>open_id</th>
                                  <th>操作</th>
                              </thead>
                              <tbody>
                              <?php if(is_array($user_data) || $user_data instanceof \think\Collection || $user_data instanceof \think\Paginator): $i = 0; $__LIST__ = $user_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$to): $mod = ($i % 2 );++$i;?>
                                <tr>
                                  <td>
                                    <input type="checkbox" name="input"  lay-skin="primary" value="<?php echo $to['id']; ?>">
                                  </td>
                                  <td><?php echo $to['id']; ?></td>
                                  <td><?php echo get_fid($to['fid']); ?></td>
                                  <td><?php echo $to['phone']; ?></td>
                                  <td><?php echo $to['name']; ?></td>
                                  <td><?php echo stamp_to_date($to['creat_time']); ?></td>
                                  <td><?php echo $to['school']; ?></td>
                                  <td><?php echo $to['courses']; ?></td>
                                  <td><?php echo second_to_hour($to['vip_time_out']); ?>小时</td>
                                 <td class="td-status">
                                     <?php if($to['use_freevip']==0): ?>
                                     <button type="button" class="layui-btn">拥有</button>
                                     <?php else: ?>
                                     <button type="button" class="layui-btn">已使用</button>
                                     <?php endif; ?>
                                 </td>
                                    <td><?php echo $to['open_id']; ?></td>
                                  <td class="td-manage">

                                    <a title="编辑"  onclick="xadmin.open('编辑','<?php echo url('user/user/edit',['id'=>$to['id']]); ?>')" href="javascript:;">
                                      <i class="layui-icon">&#xe642;</i>
                                    </a>
                                    <a title="删除" onclick="member_del(this,'<?php echo $to['id']; ?>')" href="javascript:;">
                                      <i class="layui-icon">&#xe640;</i>
                                    </a>
                                  </td>
                                </tr>
                              <?php endforeach; endif; else: echo "" ;endif; ?>
                              </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <div>
                                    <?php echo $user_data->render(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
    <script>
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var form = layui.form;
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
      });

       /*用户-停用*/
      function member_stop(obj,id){
          layer.confirm('确认要停用吗？',function(index){

              if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

              }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
              }
              
          });
      }

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              $.post('<?php echo url("user/user/del"); ?>',{id:id},function(data) {
                 if(data.statu=="succ"){
                     layer.msg(data.msg);
                 }else{
                     layer.msg(data.msg);
                 }
              });
          });
      }
      function delAll (argument) {
          var id=[];
          $.each($('input[name=input]:checked'),function(i,itesm){
               id[i]= $(itesm).val();
          });
          $.post('<?php echo url("user/user/del_all"); ?>',{id:id},function(data) {
              //发异步删除数据
              layer.msg('删除成功', {icon: 1});
              $(".layui-form-checked").not('.header').parents('tr').remove();
          });

      }
    </script>

</html>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>

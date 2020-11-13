<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:80:"D:\wwwroot\wap.pro.com\public/../application/admin\view\question\video\edit.html";i:1604981640;s:65:"D:\wwwroot\wap.pro.com\application\admin\view\layout\default.html";i:1602168706;s:62:"D:\wwwroot\wap.pro.com\application\admin\view\common\meta.html";i:1602168706;s:64:"D:\wwwroot\wap.pro.com\application\admin\view\common\script.html";i:1602168706;}*/ ?>
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
        <script type="text/javascript" src="/assets/admin/lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="/assets/admin/js/xadmin.js"></script>
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
            <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
            <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" action="<?php echo url('question/video/edit'); ?>" method="post" id="add">
                    <div class="layui-inline">
                        <label class="layui-form-label">选择类目</label>
                        <div class="layui-input-inline">
                            <select name="cid"  id="cid" lay-verify="required" lay-search="">
                                <option value="">直接选择或搜索选择</option>
                                <?php if(is_array($category_data) || $category_data instanceof \think\Collection || $category_data instanceof \think\Paginator): $i = 0; $__LIST__ = $category_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$to): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $to['id']; ?>"
                                        <?php if($ko['cid']=$to['id']): ?>
                                        selected="selected"
                                        <?php endif; ?>
                                ><?php echo render($to['level']); ?><?php echo $to['name']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                    <?php if(is_array($video_data) || $video_data instanceof \think\Collection || $video_data instanceof \think\Paginator): $i = 0; $__LIST__ = $video_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$to): $mod = ($i % 2 );++$i;?>
                  <div class="layui-form-item">
                      <label for="phone" class="layui-form-label">
                          <span class="x-red"></span>题目
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="title" name="title" required="" lay-verify="text"
                          autocomplete="off" class="layui-input" value="<?php echo $to['title']; ?>">
                      </div>
                  </div>

                  <div class="layui-form-item">
                      <label for="L_pass" class="layui-form-label">
                        视频时长
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="video_time" name="video_time" required="" lay-verify="text"
                          autocomplete="off" class="layui-input" value="<?php echo $to['video_time']; ?>">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                      以秒为单位
                      </div>
                  </div>
                    <input type="hidden" id="id" name="id" value="<?php echo $to['id']; ?>">
                    <div class="layui-form-item">
                        <label for="phone" class="layui-form-label">
                            <span class="x-red"></span>是否免费
                        </label>
                        <div class="layui-input-inline">
                            <select name="is_free" id="is_free" lay-verify="required" lay-filter="is_free"   lay-search="" >
                                <?php if($to['is_free']==1): ?>
                                <option value="0" >收费</option>
                                <option value="1" selected="selected">免费</option>
                                <?php else: ?>
                                <option value="0" selected="selected">收费</option>
                                <option value="1">免费</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item" id ="p_show" >
                        <label for="L_pass" class="layui-form-label">
                            价格
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="price" name="price" required="" autocomplete="off" class="layui-input" value="<?php echo $to['price']; ?>">
                        </div>
                    </div>
                    <div class="layui-form-item"  >
                        <label for="L_pass" class="layui-form-label">
                            上传视频
                        </label>
                        <div class="layui-input-inline">
                            <button type="button" class="layui-btn" id="video"><i class="layui-icon"></i>上传视频</button>
                            <input type="hidden" name="video_src" value="<?php echo $to['video_src']; ?>" id="video_src">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label">
                            是否显示
                        </label>
                        <div class="layui-input-block">
                            <select name="is_show" id="is_show" lay-filter="aihao">
                                <?php if($to['is_show']==1): ?>
                                <option value="1" selected="selected">显示在前台</option>
                                <option value="0">隐藏</option>
                                <?php else: ?>
                                <option value="1">显示在前台</option>
                                <option value="0" selected="selected">隐藏</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="add" lay-submit="">
                          添加
                      </button>
                  </div>
              </form>
            </div>
        </div>
        <script>
            layui.use('upload', function(){
                var $ = layui.jquery
                    ,upload = layui.upload;
                upload.render({
                    elem: '#video'
                    ,url: '<?php echo url("upload/upload_file",["name"=>"video"]); ?>' //改成您自己的上传接口
                    ,accept: 'video' //视频
                    ,done: function(res){
                        if(res.staus=='succ'){
                            $('#video_src').val(res.data);
                            layer.msg('上传成功');
                        }else{
                            layer.msg('上传失败');
                        }
                     return false;
                    }
                });
            });

            layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;
                form.on('select(is_free)', function(data){
                   switch (data.value) {
                       case '0':
                            $('#p_show').css('display','block');
                             break;
                       }
                       });
                //监听提交
                form.on('submit(add)',
                function(data) {
                    var cid=$('#cid').val();
                    var title=$('#title').val();
                    var video_time=$('#video_time').val();
                    var is_free=$('#is_free').val();
                    var price=$('#price').val();
                    var is_show=$('#is_show').val();
                    var video_src=$('#video_src').val();
                    if(!is_show||!is_free||!video_time||!title||!cid||!video_src){
                          layer.msg('请填写完整数据');
                          return false;
                    }
                    if(is_free!=='1'){
                       if(!price){
                           layer.msg('请填写价格');
                           return false;
                       }
                    }
                 $('#add').submit();
                    return false;
                });

            });</script>

    </body>

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

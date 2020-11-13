<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:83:"D:\wwwroot\wap.pro.com\public/../application/admin\view\feedback\feedback\edit.html";i:1604996999;s:65:"D:\wwwroot\wap.pro.com\application\admin\view\layout\default.html";i:1602168706;s:62:"D:\wwwroot\wap.pro.com\application\admin\view\common\meta.html";i:1602168706;s:64:"D:\wwwroot\wap.pro.com\application\admin\view\common\script.html";i:1602168706;}*/ ?>
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
    <script type="text/javascript" src="/assets/admin/js/jquery.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="/assets/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/assets/admin/lib/layui/css/layui.css" charset="utf-8"></script>
    <script type="text/javascript" src="/assets/admin/js/xadmin.js"></script>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row">
        <form class="layui-form" enctype="multipart/form-data" action="<?php echo url('feedback/feedback/edit'); ?>" method="post">
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$to): $mod = ($i % 2 );++$i;?>
            <div class="layui-form-item" style="width: 500px;">
               <!-- <label for="phone" class="layui-form-label">
                    <span class="x-red">*</span>编辑
                </label>-->
                <div class="layui-input-inline"  style="width: 500px;">
                    <textarea id="demo" name="content"  style="display: none;width: 500px;" ><?php echo $to['opinion']; ?></textarea>
                </div>
                <input type="hidden" name="id" value="<?php echo $to['id']; ?>">
            </div>
   <input type="hidden" name="id" value="<?php echo $to['id']; ?>">
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  class="layui-btn" lay-filter="add" lay-submit="">
                    回复用户
                </button>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </form>
    </div>
</div>
<script>

    layui.use('layedit', function(){
        var layedit = layui.layedit;
        layedit.build('demo'); //建立编辑器
    });

    layui.use(['form', 'layer'],
        function() {
            $ = layui.jquery;
            var form = layui.form,
                layer = layui.layer;
            //监听提交
            form.on('submit(add)',
                function(data) {
                var content=$('#demo').val();
                var id=$('#id').val();
                  if(content){
                     $.post({
                         url:"<?php echo url('feedback/feedback/edit'); ?>",
                         data:{
                             content:content,
                             id:id
                         },
                         success:function(data){
                             layer.msg(data.msg);
                         }
                     });
                  }else{
                            layer.msg('请填写内容');
                  }
                });
        });
</script>

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

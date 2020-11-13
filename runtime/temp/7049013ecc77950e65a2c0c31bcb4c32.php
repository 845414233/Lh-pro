<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:81:"D:\wwwroot\wap.pro.com\public/../application/admin\view\question\manage\edit.html";i:1604713140;s:65:"D:\wwwroot\wap.pro.com\application\admin\view\layout\default.html";i:1602168706;s:62:"D:\wwwroot\wap.pro.com\application\admin\view\common\meta.html";i:1602168706;s:64:"D:\wwwroot\wap.pro.com\application\admin\view\common\script.html";i:1602168706;}*/ ?>
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
                <form class="layui-form" action="<?php echo url('question/manage/edit'); ?>" method="post" id="edit">
                    <div class="layui-inline">
                        <label class="layui-form-label">选择类目</label>
                        <div class="layui-input-inline">
                            <select name="type" lay-verify="required" lay-search="">
                                <option value="">直接选择或搜索选择</option>
                                <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ko): $mod = ($i % 2 );++$i;if(is_array($category_data) || $category_data instanceof \think\Collection || $category_data instanceof \think\Paginator): $i = 0; $__LIST__ = $category_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$to): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $to['id']; ?>"
                                        <?php if($ko['cid']=$to['id']): ?>
                                        selected="selected"
                                        <?php endif; ?>
                                ><?php echo render($to['level']); ?><?php echo $to['name']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $ko['id']; ?>">
                  <div class="layui-form-item">
                      <label for="phone" class="layui-form-label">
                          <span class="x-red"></span>题目
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="title" name="title" required="" lay-verify="text"
                          autocomplete="off" class="layui-input" value="<?php echo $ko['title']; ?>">
                      </div>
                  </div>
                      <div class="layui-form-item">
                          <label class="layui-form-label">选择类型</label>
                          <div class="layui-input-block">
                              <select name="type" lay-filter="aihao">
                                  <?php if($ko['type']==1): ?>
                                  <option value="1"
                                          selected="selected"
                                  >专项试题</option>
                                  <option value="2"
                                  >模拟试题</option>
                                  <?php endif; if($ko['type']==2): ?>
                                  <option value="1"
                                  >专项试题</option>
                                  <option value="2"
                                          selected="selected"
                                  >模拟试题</option>
                                  <?php endif; ?>
                              </select>
                          </div>
                      </div>
                  <div class="layui-form-item">
                      <label for="L_pass" class="layui-form-label">
                        本题时常
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="set_time" name="set_time" required="" lay-verify="pass"
                          autocomplete="off" class="layui-input" value="<?php echo $ko['set_time']; ?>">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                      以秒为单位
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                        单多选
                      </label>
                      <div class="layui-input-block">
                          <select name="select_type" lay-filter="aihao">
                              <?php if($ko['select_type']==1): ?>
                              <option value="1"
                                      selected="selected"
                              >单选</option>
                              <option value="2"
                              >多选</option>
                              <?php endif; if($ko['select_type']==2): ?>
                              <option value="1"
                              >单选</option>
                              <option value="2"
                                      selected="selected"
                              >多选</option>
                              <?php endif; ?>
                          </select>
                      </div>
                  </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label">
                            是否上线
                        </label>
                        <div class="layui-input-block">
                            <select name="is_show" lay-filter="aihao">
                                <?php if($ko['is_show']==1): ?>
                                <option value="1"
                                        selected="selected"
                                >已上线</option>
                                <option value="0"
                                >已下线</option>
                                <?php endif; if($ko['select_type']==0): ?>
                                <option value="1"
                                >已上线</option>
                                <option value="0"
                                        selected="selected"
                                >已下线</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_pass" class="layui-form-label">
                            答案分析
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="analysis" name="analysis" required="" lay-verify="pass"
                                   autocomplete="off" class="layui-input" value="<?php echo $ko['analysis']; ?>">
                        </div>
                        <div class="layui-form-mid layui-word-aux">

                        </div>
                    </div>

                    <div class="layui-form-item" pane="">
                        <label class="layui-form-label">正确答案</label>
                        <div class="layui-input-block">
                            <?php if(is_array($answe) || $answe instanceof \think\Collection || $answe instanceof \think\Paginator): $i = 0; $__LIST__ = $answe;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ao): $mod = ($i % 2 );++$i;?>
                            <input type="checkbox" name="answer[<?php echo $ao['id']; ?>]" lay-skin="primary" title="<?php echo $ao['content']; ?>"
                                  <?php if($ao['is_true']==1): ?>
                                   checked=""
                                   <?php endif; ?>
                            ><br>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="add" lay-submit="">
                          修改
                      </button>
                  </div>
              </form>
            </div>
        </div>
        <script>
            layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                //自定义验证规则
            /*    form.verify({
                    nikename: function(value) {
                        if (value.length < 5) {
                            return '昵称至少得5个字符啊';
                        }
                    },
                    pass: [/(.+){6,12}$/, '密码必须6到12位'],
                    repass: function(value) {
                        if ($('#L_pass').val() != $('#L_repass').val()) {
                            return '两次密码不一致';
                        }
                    }
                });*/

                //监听提交
                form.on('submit(add)',
                function(data) {
                    console.log(data);
                    //发异步，把数据提交给php
                 /*   layer.alert("增加成功", {
                        icon: 6
                    },


                    function() {
                        //关闭当前frame
                        xadmin.close();

                        // 可以对父窗口进行刷新
                        xadmin.father_reload();
                    });*/
                 $('#edit').submit();
                 /*   $.ajax({
                        url: '<?php echo url("question/manage/edit"); ?>',
                        data: data.field,
                        success: function (data) {
                            layer.msg("提交成功")
                        }
                    });*/
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

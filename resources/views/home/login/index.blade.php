
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>用户登录</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="网站关键词">
    <meta name="Description" content="网站介绍">
    <link rel="stylesheet" href="/home/login/css/base.css">
    <link rel="stylesheet" href="/home/login/css/iconfont.css">
    <link rel="stylesheet" href="/home/login/css/reg.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/layui/css/layui.css">
    <script src="/layui/layui.js"></script>
    <script>
        layui.use(['layer', 'form'], function(){
          var layer = layui.layer;
        });
    </script> 
</head>
<body>
<div id="ajax-hook"></div>
<div class="wrap">
    <div class="wpn">
        <div class="form-data pos">
            <a href=""><img src="/home/login/img/logo.png" class="head-logo"></a>
            <div class="change-login">
                <p class="account_number on">账号登录</p>
            </div>
            <div class="form1">
                <p class="p-input pos">
                    <label for="uname">用户名</label>
                    <input type="text" id="uname" name="uname" value="" autocomplete="off">
                </p>
                <p class="p-input pos">
                    <label for="upass">请输入密码</label>
                    <input type="password" id="upass" name="upass" value="" autocomplete="off">
                </p>
            </div>
            <div class="r-forget cl">
                <a href="javascript:;" onclick="create()" class="z">账号注册</a>
                <script type="text/javascript">
                    function create()
                    {
                      layer.open({
                        type: 2,
                        title: '注册',
                        area: ['700px', '450px'],
                        fixed: false, //不固定
                        maxmin: true,
                        content: '/home/register/create'
                      });
                    }
                </script>
                <a href="javascript:;" class="y">忘记密码</a>
            </div>
            <button class="lang-btn off log-btn" onclick="dologin()">登录</button>
            <div class="third-party">
                <a href="javascript:;" class="log-qq icon-qq-round"></a>
                <a href="javascript:;" class="log-qq icon-weixin"></a>
                <a href="javascript:;" class="log-qq icon-sina1"></a>
            </div>
            <p class="right">Powered by © 2018</p>
        </div>
    </div>
</div>
<script src="/home/login/js/jquery.js"></script>
<script src="/home/login/js/agree.js"></script>
<script src="/home/login/js/login.js"></script>
</body>
</html>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // 登录操作
    function dologin()
    {
        // 获取账号密码
        let uname = $(".form1 input[name='uname']").eq(0).val();
        let upass = $(".form1 input[name='upass']").eq(0).val(); 
        
        // 发送ajax
        $.post('/home/login/dologin',{uname:uname,upass:upass},function(res){
            if (res.msg=='ok') {
                layer.msg(res.info);
                window.location.href = '/';
            } else {
                layer.msg(res.info);
            }
        },'json');
    }
</script>
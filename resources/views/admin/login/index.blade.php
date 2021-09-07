<!DOCTYPE html>
<!-- saved from url=(0059)http://demo.mxyhn.xyz:8020/cssthemes6/skk-0720-2/index.html -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Login Form</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/admin/login/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>



    <div class="main">
        <div class="login">
            <h1>管理系统</h1>
            <div class="inset">
                <!--start-main-->
                <form action="/admin/login/doLogin" method="post">
                	{{ csrf_field() }}
                    <div>
                        <h2>管理登录</h2>
                        <span><label>用户名</label></span>
                        <span><input type="text" class="textbox" name="uname"></span>
                    </div>
                    <div>
                        <span><label>密码</label></span>
                        <span><input type="password" class="password" name="upass"></span>
                    </div>
                    <div style="text-align: center">{{ session('error') }}</div>
                    <div class="sign">
                        <input type="submit" value="登录" class="submit">
                    </div>
                </form>
            </div>
        </div>
        <!--//end-main-->
    </div>

    <div class="copy-right">
        <p>© 2015 Ethos Login Form. All Rights Reserved</p>

    </div>
    <div style="text-align:center;">
        <p>更多模板：<a href="http://www.cssmoban.com/" target="_blank">模板之家</a></p>
    </div>

    <div class="xl-chrome-ext-bar" id="xl_chrome_ext_{4DB361DE-01F7-4376-B494-639E489D19ED}" style="display: none;">
        <div class="xl-chrome-ext-bar__logo"></div>

        <a id="xl_chrome_ext_download" href="javascript:;" class="xl-chrome-ext-bar__option">下载视频</a>
        <a id="xl_chrome_ext_close" href="javascript:;" class="xl-chrome-ext-bar__close"></a>
    </div>
</body>

</html>
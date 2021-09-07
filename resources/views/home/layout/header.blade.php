  <div class="menu">
    <nav class="nav" id="topnav">
      <h1 class="logo"><a href="/">BLOG</a></h1>
      
      <!-- 导航栏 开始 -->
      @foreach($cates_data as $cate_data)
      <li><a href="javascript:;">{{ $cate_data->cname }}</a>
        <ul class="sub-nav">
          @foreach($cate_data->sub as $key=>$cname)
          <li><a href="/home/list/index/cid/{{ $key }}/{{ $cname }}">{{ $cname }}</a></li>
          @endforeach
        </ul>
      </li>
      @endforeach
      <!-- 导航栏 结束 -->
      
      <!-- 搜索框 开始 -->
      <div id="search_bar" class="search_bar" style="position: relative;left:-145px">
        <form action="/home/search/index" name="searchform" id="searchform"  method="get">
          {{ csrf_field() }}
          <input type="text" name="search" id="keyboard" class="input" autocomplete="off">
          <span class="search_ico"></span>
        </form>
      </div>
      <!-- 搜索框 结束 --> 

      @if(session('home_login'))
      <div id="index_login" style="position: relative;right:-600px;">
        <a href="javascript:;" title="" style="color:#BDBDBD">{{ session('home_userinfo')->uname }}</a>
        <a href="/home/login/logout" title="" style="color:#BDBDBD">退出</a>
      </div>
      @else
      <link rel="stylesheet" href="/layui/css/layui.css">
      <script src="/layui/layui.js"></script>
      <script>
        layui.use(['layer', 'form'], function(){
          var layer = layui.layer;
        });
      </script>
      <div id="index_login" style="position: relative;right:-600px;">
        <a href="/home/login/index" title="" style="color:#BDBDBD">登录</a>
        <a href="javascript:;" title="" style="color:#BDBDBD" onclick="create()">注册</a>
      </div>
      @endif  
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
    </nav>
  </div>

  <!--mnav begin-->
<!--   <div id="mnav">
    <h2><a href="http://www.yangqq.com" class="mlogo">杨青博客</a><span class="navicon"></span></h2>
    <dl class="list_dl">
      <dt class="list_dt"> <a href="index.html">网站首页</a> </dt>
      <dt class="list_dt"> <a href="about.html">关于我</a> </dt>
      <dt class="list_dt"> <a href="#">模板分享</a> </dt>
      <dd class="list_dd">
        <ul>
          <li><a href="share.html">个人博客模板</a></li>
          <li><a href="share.html">国外Html5模板</a></li>
          <li><a href="share.html">企业网站模板</a></li>
        </ul>
      </dd>
      <dt class="list_dt"> <a href="#">学无止境</a> </dt>
      <dd class="list_dd">
        <ul>
          <li><a href="list.html">心得笔记</a></li>
          <li><a href="list.html">CSS3|Html5</a></li>
          <li><a href="list.html">网站建设</a></li>
          <li><a href="list.html">推荐工具</a></li>
          <li><a href="list.html">JS实例索引</a></li>
        </ul>
      </dd>
      <dt class="list_dt"> <a href="#">慢生活</a> </dt>
      <dd class="list_dd">
        <ul>
          <li><a href="life.html">日记</a></li>
          <li><a href="life.html">欣赏</a></li>
          <li><a href="life.html">程序人生</a></li>
          <li><a href="life.html">经典语录</a></li>
        </ul>
      </dd>
      <dt class="list_dt"> <a href="time.html">时间轴</a> </dt>
      <dt class="list_dt"> <a href="gbook.html">留言</a> </dt>
    </dl>
  </div> -->
  <!--mnav end--> 
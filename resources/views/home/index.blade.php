
<!doctype html>
<html>
<head>
  <!-- head 开始 -->
  @include('home.layout.head')
  <!-- head 结束 -->
</head>
<body>
<header> 
  <!-- header 开始 -->
  @include('home.layout.header')
  <!-- header 结束 -->
</header>
<article> 

  <!-- 轮播图 开始 -->
 <div class="picsbox"> 
    <div class="banner">
      <div id="banner" class="fader">
        @foreach($banner_data as $v)
        <li class="slide" >
          <a href="javascript:;">
            <img src="/uploads/{{ $v->url }}">
            <span class="imginfo">{{ $v->title }}</span>
          </a>
        </li>
        @endforeach
        <div class="fader_controls">
          <div class="page prev" data-target="prev">&lsaquo;</div>
          <div class="page next" data-target="next">&rsaquo;</div>
          <ul class="pager_list">
          </ul>
        </div>
      </div>
    </div>
  <!-- 轮播图 结束 -->

  <div class="toppic">
    <li> <a href="/" target="_blank"> <i><img src="/home/images/toppic01.jpg"></i>
      <h2>别让这些闹心的套路，毁了你的网页设计!</h2>
      <span>学无止境</span> </a> </li>
    <li> <a href="/" target="_blank"> <i><img src="/home/images/zd01.jpg"></i>
      <h2>个人博客，属于我的小世界！</h2>
      <span>学无止境</span> </a> </li>
  </div>
  </div>
  <div class="blank"></div>

  <!-- 首页默认文章 开始 -->
  <div class="blogsbox">
    @if($total < 1)
      <div class="blogs" data-scroll-reveal="enter bottom over 1s" >
        暂无数据
      </div>
    @else
      @foreach($articles_data as $v)
      <div class="blogs" data-scroll-reveal="enter bottom over 1s" >
        <h3 class="blogtitle">
          <a href="/home/detail/index/{{ $v->id }}/{{ $v->cid }}/{{ $cateNames_data[$v->cid] }}" target="_blank">{{ $v->title }}</a>
        </h3>
        <span class="blogpic"><a href="javascript:;" title=""><img data-src="holder.js/140x140" class="img-thumbnail" alt="140x140" src="/uploads/{{ $v->thumb }}" data-holder-rendered="true" style="width: 200px; height: 125px;"></a></span>
        <p class="blogtext">{{ $v->desc }}</p>
        <div class="bloginfo">
          <ul>
            <li class="author"><a href="javascript:;">{{ $v->author }}</a></li>
            <li class="lmname"><a href="javascript:;">{{ $cateNames_data[$v->cid] }}</a></li>
            <li class="timer">{{ $v->ctime }}</li>
            <li class="view"><span>{{ $v->readnum }}</span>已阅读</li>
            <li class="like">{{ $v->goodnum }}</li>
          </ul>
        </div>
      </div>
      @endforeach
    @endif
    <!-- 分页 开始 -->
    <div id="pagelist"></div>
    
    <link rel="stylesheet" href="/layui/css/layui.css">
    <script src="/layui/layui.js"></script>
    <script>
      layui.use('laypage', function(){
        var laypage = layui.laypage;
        let count = "{{ $total }}",// 总条数
            limit = "{{ $limit }}",// 每页显示多少条
            current_page = "{{ $current_page }}",// 当前页码
            url = ''; // 
        //执行一个laypage实例
        laypage.render({
          elem: 'pagelist', // 获取DOM
          count: count, 
          limit: limit, 
          curr: current_page, 
          limits: [5,10,20,30,40,50], // 每页显示多少条选项
          groups: 5, // 连续显示10个页码
          layout: ['prev','page','next','limit','count'],
          jump: function(obj, first){
            if (url.indexOf('?') >= 0) {
              url = url.split('?')[0] + '?page=' + obj.curr;
            } else {
              url = url + '?page=' + obj.curr;
            }

            //首次不执行
            if(!first){
              location.href = url;
            }
          }
        });
      });
    </script>
    <!-- 分页 结束 -->
  </div>
  <!-- 首页默认文章 结束 -->

  <!-- 侧边栏 开始 -->
  @include('home.layout.sidebar')
  <!-- 侧边栏 结束 -->

  </div>
</article>
<footer>
  <p>Design by <a href="http://www.yangqq.com" target="_blank">杨青个人博客</a> <a href="/">蜀ICP备11002373号-1</a></p>
</footer>
<a href="#" class="cd-top">Top</a>
</body>
</html>

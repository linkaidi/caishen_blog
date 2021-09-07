
<!doctype html>
<html>
  <head>
    <!-- head 开始 -->
    @include('home.layout.head')
    <!-- head 结束 -->
    <link rel="stylesheet" href="/layui/css/layui.css">
    <script src="/layui/layui.js"></script>
    <script>
        layui.use(['layer', 'form'], function(){
          var layer = layui.layer;
        });
    </script>
  </head>
<body>
<header> 
  <!-- header 开始 -->
  @include('home.layout.header')
  <!-- header 结束 -->
</header>
<article>
  <h1 class="t_nav"><span>您现在的位置是：首页 > {{ $cate_parent_name }} > {{ $cname }}</span><a href="/" class="n1">网站首页</a><a href="/home/list/index/cid/{{ $cid }}" class="n2">{{ $cname }}</a></h1>
  <div class="infosbox">
    <div class="newsview">
      <h3 class="news_title">{{ $article_data->title }}</h3>
      <div class="bloginfo">
        <ul>
          <li class="author"><a href="javascript:;">{{ $article_data->author }}</a></li>
          <li class="lmname"><a href="/home/list/index/cid/{{ $cid }}">{{ $cname }}</a></li>
          <li class="timer">{{ $article_data->ctime }}</li>
          <li class="view">{{ $article_data->readnum }}已阅读</li>
          <li class="like">{{ $article_data->goodnum }}</li>
        </ul>
      </div>
      
      <!-- 所属标签 开始 -->
      <div class="tags">
        <a href="/home/list/index/tid/{{ $tid }}">{{ $tagname }}</a> &nbsp; 
      </div>
      <!-- 所属标签 结束 -->

      <div class="news_about"><strong>简介</strong>{{ $article_data->desc }}</div>
      <div class="news_con">{!! $article_data->content !!}</div>
    </div>
    <div class="share">
      <p class="diggit">
        <a href="javascript:;" onclick="goodnum({{ $article_data->id }})"> 很赞哦！ </a>
      </p>
      <script type="text/javascript">
        // 点赞数
        function goodnum(aid)
        {
          // 发送ajax
          $.get('/home/detail/goodnum',{aid:aid},function(res){
            if (res.msg=='ok') {
              // 点赞成功，点赞数dom +1
              let like = $('.like').eq(0);
              like = parseInt(like.html());
              $('.like').eq(0).html(like+1);
              // 提示点赞成功
              layer.msg(res.info);
            } else if (res.msg=='error') {
              // 提示点赞失败
              layer.msg(res.info);
            }
          },'json'); 
        }
      </script>
      <p class="dasbox">
        <a href="javascript:void(0)" onClick="dashangToggle()" class="dashang" title="打赏，支持一下">打赏本站</a>
      </p>
      <div class="hide_box"></div>
      <div class="shang_box"> <a class="shang_close" href="javascript:void(0)" onclick="dashangToggle()" title="关闭">关闭</a>
        <div class="shang_tit">
          <p>感谢您的支持，我会继续努力的!</p>
        </div>
        <div class="shang_payimg"> <img src="/home/images/wx.jpg" alt="扫码支持" title="扫一扫"> </div>
        <div class="pay_explain">扫码打赏，你说多少就多少</div>
        <div class="shang_payselect">
          <div class="pay_item checked" data-id="alipay"> <span class="radiobox"></span> <span class="pay_logo"><img src="/home/images/alipay.jpg" alt="支付宝"></span> </div>
          <div class="pay_item" data-id="weipay"> <span class="radiobox"></span> <span class="pay_logo"><img src="/home/images/wechat.jpg" alt="微信"></span> </div>
        </div>
        <script type="text/javascript">
    $(function(){
    	$(".pay_item").click(function(){
    		$(this).addClass('checked').siblings('.pay_item').removeClass('checked');
    		var dataid=$(this).attr('data-id');
    		$(".shang_payimg img").attr("src","images/"+dataid+"img.jpg");
    		$("#shang_pay_txt").text(dataid=="alipay"?"支付宝":"微信");
    	});
    });
    function dashangToggle(){
    	$(".hide_box").fadeToggle();
    	$(".shang_box").fadeToggle();
    }
    </script> 
      </div>
    </div>
    <div class="nextinfo">
      <p>上一篇：
        @if($article_prev_data)
        <a href="/home/detail/index/{{ $article_prev_data->id }}/{{ $article_prev_data->cid }}/{{ $cname }}">{{ $article_prev_data->title }}</a>
        @endif
      </p>
      <p>下一篇：
        @if($article_next_data)
        <a href="/home/detail/index/{{ $article_next_data->id }}/{{ $article_next_data->cid }}/{{ $cname }}">{{ $article_next_data->title }}</a>
        @endif
      </p>
    </div>
    <div class="otherlink">
      <h2>相关文章</h2>
      <ul>
        <li><a href="/download/div/2018-04-22/815.html" title="html5个人博客模板《黑色格调》">html5个人博客模板《黑色格调》</a></li>
        <li><a href="/download/div/2018-04-18/814.html" title="html5个人博客模板主题《清雅》">html5个人博客模板主题《清雅》</a></li>
        <li><a href="/download/div/2018-03-18/807.html" title="html5个人博客模板主题《绅士》">html5个人博客模板主题《绅士》</a></li>
        <li><a href="/download/div/2018-02-22/798.html" title="html5时尚个人博客模板-技术门户型">html5时尚个人博客模板-技术门户型</a></li>
        <li><a href="/download/div/2017-09-08/789.html" title="html5个人博客模板主题《心蓝时间轴》">html5个人博客模板主题《心蓝时间轴》</a></li>
        <li><a href="/download/div/2017-07-16/785.html" title="古典个人博客模板《江南墨卷》">古典个人博客模板《江南墨卷》</a></li>
        <li><a href="/download/div/2017-07-13/783.html" title="古典风格-个人博客模板">古典风格-个人博客模板</a></li>
        <li><a href="/download/div/2015-06-28/748.html" title="个人博客《草根寻梦》—手机版模板">个人博客《草根寻梦》—手机版模板</a></li>
        <li><a href="/download/div/2015-04-10/746.html" title="【活动作品】柠檬绿兔小白个人博客模板">【活动作品】柠檬绿兔小白个人博客模板</a></li>
        <li><a href="/jstt/bj/2015-01-09/740.html" title="【匆匆那些年】总结个人博客经历的这四年…">【匆匆那些年】总结个人博客经历的这四年…</a></li>
      </ul>
    </div>
    <div class="news_pl">
      <h2>文章评论</h2>
      <ul>
        <div class="gbko"> </div>
      </ul>
    </div>
  </div>

  <!-- 侧边栏 开始 -->
  @include('home.layout.sidebar')
  <!-- 侧边栏 结束 -->

</article>
<footer>
  <p>Design by <a href="http://www.yangqq.com" target="_blank">杨青个人博客</a> <a href="/">蜀ICP备11002373号-1</a></p>
</footer>
<a href="#" class="cd-top">Top</a>
</body>
</html>

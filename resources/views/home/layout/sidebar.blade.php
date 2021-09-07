<div class="sidebar">
  <div class="zhuanti">
    <h2 class="hometitle">特别推荐</h2>
    <ul>
      <li> <i><img src="/home/images/banner03.jpg"></i>
        <p>帝国cms调用方法 <span><a href="/">阅读</a></span> </p>
      </li>
      <li> <i><img src="/home/images/b04.jpg"></i>
        <p>5.20 我想对你说 <span><a href="/">阅读</a></span></p>
      </li>
      <li> <i><img src="/home/images/b05.jpg"></i>
        <p>个人博客，属于我的小世界！ <span><a href="/">阅读</a></span></p>
      </li>
    </ul>
  </div>
  <div class="tuijian">
    <h2 class="hometitle">推荐文章</h2>
    <ul class="tjpic">
      <i><img src="/home/images/toppic01.jpg"></i>
      <p><a href="javascript:;">别让这些闹心的套路，毁了你的网页设计</a></p>
    </ul>
    <ul class="sidenews">
      <li> <i><img src="/home/images/toppic01.jpg"></i>
        <p><a href="javascript:;">别让这些闹心的套路，毁了你的网页设计</a></p>
        <span>2018-05-13</span> </li>
      <li> <i><img src="/home/images/toppic02.jpg"></i>
        <p><a href="javascript:;">给我模板PSD源文件，我给你设计HTML！</a></p>
        <span>2018-05-13</span> </li>
      <li> <i><img src="/home/images/v1.jpg"></i>
        <p><a href="javascript:;">别让这些闹心的套路，毁了你的网页设计</a></p>
        <span>2018-05-13</span> </li>
      <li> <i><img src="/home/images/v2.jpg"></i>
        <p><a href="javascript:;">给我模板PSD源文件，我给你设计HTML！</a></p>
        <span>2018-05-13</span> </li>
    </ul>
  </div>
  <div class="tuijian">
    <h2 class="hometitle">点击排行</h2>
    <ul class="tjpic">
      <i><img src="/home/images/toppic01.jpg"></i>
      <p><a href="javascript:;">别让这些闹心的套路，毁了你的网页设计</a></p>
    </ul>
    <ul class="sidenews">
      <li> <i><img src="/home/images/toppic01.jpg"></i>
        <p><a href="javascript:;">别让这些闹心的套路</a></p>
        <span>2018-05-13</span> </li>
      <li> <i><img src="/home/images/toppic02.jpg"></i>
        <p><a href="javascript:;">给我模板PSD源文件，我给你设计HTML！</a></p>
        <span>2018-05-13</span> </li>
      <li> <i><img src="/home/images/v1.jpg"></i>
        <p><a href="javascript:;">别让这些闹心的套路，毁了你的网页设计</a></p>
        <span>2018-05-13</span> </li>
      <li> <i><img src="/home/images/v2.jpg"></i>
        <p><a href="javascript:;">给我模板PSD源文件，我给你设计HTML！</a></p>
        <span>2018-05-13</span> </li>
    </ul>
  </div>

  <!--  -->

  <!-- 标签云 开始 -->
  <div class="cloud">
    <h2 class="hometitle">标签云</h2>
    <ul>
      @foreach($tag_data as $v)
      <a href="/home/list/index/tid/{{ $v->id }}" style="background-color:{{ $v->bgcolor }}">{{ $v->tagname }}</a> 
      @endforeach
    </ul>
  </div>
  <!-- 标签云 结束 -->
  
  <div class="links">
    <h2 class="hometitle">友情链接</h2>
    <ul>
      <li><a href="javascript:;" target="_blank">财神博客</a></li>
      <li><a href="javascript:;" target="_blank">财神博客</a></li>
      <li><a href="javascript:;" target="_blank">财神博客</a></li>
    </ul>
  </div>
  <div class="guanzhu" id="follow-us">
    <h2 class="hometitle">关注我们 么么哒！</h2>
    <ul>
      <li class="sina"><a href="javascript:;" target="_blank"><span>新浪微博</span>财神博客</a></li>
      <li class="tencent"><a href="javascript:;" target="_blank"><span>腾讯微博</span>财神博客</a></li>
      <li class="qq"><a href="javascript:;" target="_blank"><span>QQ号</span>12345678</a></li>
      <li class="email"><a href="javascript:;" target="_blank"><span>邮箱帐号</span>12345678@qq.com</a></li>
      <li class="wxgzh"><a href="javascript:;" target="_blank"><span>微信号</span>caishen123</a></li>
      <li class="wx"><img src="/home/images/wx.jpg" height=""></li>
    </ul>
  </div>
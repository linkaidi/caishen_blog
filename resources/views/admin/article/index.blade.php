@include('admin.layout.head')
	<h3 class="title1">文章管理</h3>
	<div class="form-body" data-example-id="simple-form-inline">
	    <form action="/admin/article/index" method="get" class="form-inline">
	        <div class="form-group"> 
	        	<label for="serach">文章标题</label> 
	        	<input type="text" class="form-control" id="serach" name="serach" value="{{ $serach }}" placeholder="文章标题"> 
	        </div>
            <button type="submit" class="btn btn-default">搜索</button>
            <a href="/admin/article/index" class="btn btn-default">返回</a>
	    </form>
	</div>
	<div class="panel-body widget-shadow">
    <h4>文章列表</h4>
    <style type="text/css" media="screen">
        .article_text {
            overflow: hidden; /*自动隐藏文字*/
            text-overflow: ellipsis;/*文字隐藏后添加省略号*/
            white-space: nowrap;/*强制不换行*/
        }
        .article-title {width:80px;}
        .article-author {width:50px;}
        .article-desc {width:200px;}
    </style>
    <table class="table table-bordered ">
        <thead>
            <tr class="info">
                <th>编号</th>
                <th>标题</th>
                <th>作者</th>
                <th>描述</th>
                <th>标签</th>
                <th>栏目</th>
                <th>缩略图</th>
                <th>创建时间</th>
                <th>阅读量</th>
                <th>点赞量</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
        	@foreach ($data as $v)
            <tr class="active">
                <td>{{ $v->id }}</td>
                <td><p class="article_text article-title" title="{{ $v->title }}">{{ $v->title }}</p></td>
                <td><p class="article_text article-author" title="{{ $v->author }}">{{ $v->author }}</p></td>
                <td><p class="article_text article-desc" title="{{ $v->desc }}">{{ $v->desc }}</p></td>
                <td>
                    @foreach($tags as $tag)
                        @if ($tag->id==$v->tid) 
                            <p style="text-align: center;background-color:{{ $tag->bgcolor }}">{{$tag->tagname}}</p>
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($cates as $cate)
                        @if ($cate->id==$v->cid) 
                            {{$cate->cname}}
                        @endif
                    @endforeach
                </td>
                <td>
                    <img data-src="holder.js/140x140" src="/uploads/{{ $v->thumb }}" alt="缩略图" class="img-thumbnail"  data-holder-rendered="true" style="width: 300px; height: 160px;">
                </td>
                <td>{{ $v->ctime }}</td>
                <td>{{ $v->readnum }}</td>
                <td>{{ $v->goodnum }}</td>
                <td>
                    <a href="/admin/article/edit/{{ $v->id }}" title="修改" class="btn btn-info">修改</a>
                    <a href="javascript:;" onclick="destory({{$v->id}},this)" title="删除" class="btn btn-danger">删除</a>
                    <a href="javascript:;" onclick="show({{$v->id}})" title="查看文章" class="btn btn-primary">查看文章</a>
                    <script>
                        function show(id)
                        {
                            $.get('/admin/article/show',{id:id},function(data){
                                if (data.msg!='error') {
                                    $('#myModal').find('#myModalLabel').html('标题<br>'+data.title);
                                    $('#myModal').find('.modal-body').html('文章内容<br>'+data.content);
                                    $('#myModal').modal('show');
                                }
                            },'json');
                        }
                        function destory(id,obj)
                        {
                            if (confirm('你确定要删除吗？')) {
                                $.get('/admin/article/destory',{id:id},function(msg){
                                    if (msg=='OK') {
                                        $(obj).parent().parent().remove();
                                    } else {
                                        alert('删除失败');
                                    }
                                },'html');
                            }
                        }
                    </script>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
<!-- 模态框开始 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:850px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">文章标题</h4>
      </div>
      <div class="modal-body">
        文章内容
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- 模态框结束 -->

    {{ $data->appends(['serach' => $serach])->links() }}
</div>
@include('admin.layout.foot')
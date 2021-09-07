@include('admin.layout.head')
	<h3 class="title1">轮播图管理</h3>
	<div class="form-body" data-example-id="simple-form-inline">
	    <form action="/admin/banner/index" method="get" class="form-inline">
	        <div class="form-group"> 
	        	<label for="serach">关键字</label> 
	        	<input type="text" class="form-control" id="serach" name="serach" value="" placeholder="轮播图名称"> 
	        </div>
            <button type="submit" class="btn btn-default">搜索</button>
            <a href="/admin/banner/index" class="btn btn-default">返回</a>
	    </form>
	</div>
	<div class="panel-body widget-shadow">
    <h4>轮播图列表</h4>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>名称</th>
                <th>描述</th>
                <th>轮播图</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $v)
            <tr>
                <th>{{ $v->id }}</th>
                <td>{{ $v->title }}</td>
                <td >
                    <p style="width:150px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;">
                        {{ $v->desc }}
                    </p>
                </td>
                <td>
                    <img data-src="holder.js/140x140" src="/uploads/{{ $v->url }}" alt="轮播图" class="img-thumbnail"  data-holder-rendered="true" style="width: 300px; height: 160px;">
                </td>
                <td>
                    @if ($v->status)
                        <kbd class="btn-info">激活</kbd>
                    @else
                        <kbd>未激活</kbd>
                    @endif
                </td>
                <td>
                    <a class="btn btn-info" href="/admin/banner/edit/{{ $v->id }}" title="修改">修改</a>
                    <a class="btn btn-danger" onclick="destory({{$v->id}},this)" href="javascript:;" title="删除">删除</a>
                    @if($v->status)
                        <a class="btn btn-primary" onclick="changeStatus({{$v->id}},1)" href="javascript:;" title="激活">停止</a>
                    @else
                        <a class="btn btn-success" onclick="changeStatus({{$v->id}},0)" href="javascript:;" title="激活">激活</a>
                    @endif
                </td>
            </tr>
            @endforeach
                <script type="text/javascript">
                    function changeStatus(id,status)
                    {
                        // 选中状态
                        if (status) {
                            $('form input[type=radio]').eq(1).attr('checked',true);
                        } else {
                            $('form input[type=radio]').eq(0).attr('checked',true);
                        }   
                        // 给隐藏域id赋值
                        $('form input[type=hidden]').val(id);
                        // 手动打开模态框
                        $('#myModal').modal('show');
                    }

                    function destory(id,obj)
                    {
                        if (confirm('你确定要删除吗？')) {
                            $.get('/admin/banner/destory',{id:id},function(msg){
                                if (msg=='OK') {
                                    $(obj).parent().parent().remove();
                                } else {
                                    alert('删除失败');
                                }
                            },'html');
                        }
                    }
                </script>
        </tbody>
    </table>
    {{ $data->appends(['serach' => $serach])->links() }}
</div>
    

    <!-- 模态框开始 -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">轮播图状态</h4>
          </div>
            <div class="modal-body">
                <form action="/admin/banner/changeStatus" method="get" accept-charset="utf-8">
                    <input type="hidden" name="id">
                    未激活：<input type="radio" name="status" value="0">&nbsp;&nbsp;&nbsp;
                    激活：<input type="radio" name="status" value="1">
                    </div>
                    <div class="modal-footer">
                    <button type="" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">更改状态</button>
            </div>
                </form>
        </div>
      </div>
    </div>
    <!-- 模态框结束 -->

@include('admin.layout.foot')
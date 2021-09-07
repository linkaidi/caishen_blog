@include('admin.layout.head')
	<h3 class="title1">用户管理</h3>
	<div class="form-body" data-example-id="simple-form-inline">
	    <form action="/admin/user/index" method="get" class="form-inline">
	        <div class="form-group"> 
	        	<label for="serach">用户名</label> 
	        	<input type="text" class="form-control" id="serach" name="serach" value="{{ $serach }}" placeholder="用户名"> 
	        </div>
            <button type="submit" class="btn btn-default">搜索</button>
            <a href="/admin/user/index" class="btn btn-default">返回</a>
	    </form>
	</div>
	<div class="panel-body widget-shadow">
    <h4>用户列表</h4>
    
    <table class="table table-bordered ">
        <thead>
            <tr class="info">
                <th>编号</th>
                <th>用户名</th>
                <th>头像</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
        	@foreach ($data as $v)
            <tr class="active">
                <td>{{ $v->id }}</td>
                <td>{{ $v->uname }}</td>
                <td>
                	<img data-src="holder.js/140x140" class="img-thumbnail" alt="140x140" src="/uploads/{{ $v->profile }}" data-holder-rendered="true" style="width: 100px; height: 100px;">
                </td>
                <td>
                	@if ($v->status)
                		<kbd class="btn-info">激活</kbd>
                	@else
                		<kbd>未激活</kbd>
                	@endif
                </td>
                <td>{{ $v->ctime }}</td>
                <td>
                	<a href="/admin/user/edit/{{ $v->id }}/{{ $v->token }}" class="btn btn-info">修改</a>
                	<a href="javascript:;" onclick="destory({{$v->id}},this)" token="{{ $v->token }}" class="btn btn-danger">删除</a>
                </td>
            </tr>
                <script type="text/javascript">
                    // 删除用户
                    function destory(id,obj)
                    {
                        if (confirm('你确定要删除吗？')) {
                            let token = $(obj).attr('token');
                            $.get('/admin/user/destory',{id:id,token:token},function(msg){
                                if (msg=='OK') {
                                    $(obj).parent().parent().remove();
                                } else {
                                    alert('删除失败');
                                }
                            },'html');  
                        }
                    }
                </script>
            @endforeach
        </tbody>
    </table>
    {{ $data->appends(['serach' => $serach])->links() }}
</div>
@include('admin.layout.foot')
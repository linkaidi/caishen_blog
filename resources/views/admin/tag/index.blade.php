@include('admin.layout.head')
	<style type="text/css" media="screen">
        .tagname {
            text-align:center;
        }
    </style>
    <h3 class="title1">标签云管理</h3>
<!-- 搜索框开始 -->
    <div class="form-body" data-example-id="simple-form-inline">
        <form action="/admin/tag/index" method="get" class="form-inline">
            <div class="form-group"> 
                <label for="serach">标签云</label> 
                <input type="text" class="form-control" id="serach" name="serach" value="{{ $serach }}" placeholder="标签云"> 
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
            <a href="/admin/tag/index" class="btn btn-default">返回</a>
        </form>
    </div>
<!-- 搜索框结束 -->
	
    <div class="panel-body widget-shadow">
    <h4>标签云列表</h4>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>标签云</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $v)
            <tr>
                <th>{{ $v->id }}</th>
                <td>
                    <span class="tagname" style="background-color:{{ $v->bgcolor }};">
                        &nbsp;&nbsp;{{ $v->tagname }}&nbsp;&nbsp;
                    </span>
                </td>
                <td>
                    <a href="/admin/tag/edit/{{$v->id}}" class="btn btn-info" title="修改">修改</a>
                    <a href="javascript:;" onclick="destory({{$v->id}},this)" class="btn btn-danger" title="删除">删除</a>
                </td>
            </tr>
            @endforeach
                <script type="text/javascript">
                    function destory(id,obj)
                    {
                        if (confirm('你确定要删除吗？')) {                       
                            $.get('/admin/tag/destory',{id:id},function(msg){
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
    {{ $data->appends(['serach'=>$serach])->links() }}
</div>
    

@include('admin.layout.foot')
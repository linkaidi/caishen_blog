@include('admin.layout.head')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<h3 class="title1">文章管理</h3>
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>添加文章</h4>
    </div>
    <div class="form-body">
        <form action="/admin/article/update/{{ $data->id }}" method="post" enctype="multipart/form-data">
        	{{ csrf_field() }}
            <div class="form-group"> 
            	<label for="title">标题</label> 
            	<input type="text" class="form-control" id="title" name="title" value="{{ $data->title }}" placeholder="">
            </div>
            <div class="form-group"> 
                <label for="author">作者</label> 
                <input type="text" class="form-control" id="author" name="author" value="{{ $data->author }}" placeholder="">
            </div>
            <div class="form-group"> 
                <label for="desc">描述</label> 
                <textarea name="desc" class="form-control" id="desc">{{ $data->desc }}</textarea>
            </div>
            <div class="form-group"> 
                <label>标签云</label> 
                @foreach ($tags as $v)
                @if ($v->id==$data->tid)
                <input type="radio" checked id="{{ $v->id }}" name="tid" value="{{ $v->id }}">
                @else
                <input type="radio" id="{{ $v->id }}" name="tid" value="{{ $v->id }}">
                @endif
                <label for="{{ $v->id }}" style="background-color:{{ $v->bgcolor }}">&nbsp;&nbsp;{{ $v->tagname }}&nbsp;&nbsp;</label> 
                @endforeach
            </div>
            <div class="form-group"> 
                <label for="cid">栏目</label> 
                <select name="cid" class="form-control">
                    <option value="0">---请选择---</option>
                    @foreach ($cates as $v)
                    @if ($v->pid) 
                    @if ($v->id==$data->cid)
                    <option value="{{ $v->id }}" selected>|------{{ $v->cname }}</option>
                    @else
                    <option value="{{ $v->id }}">|------{{ $v->cname }}</option>
                    @endif
                    @else 
                    <option value="{{ $v->id }}"  disabled style="color:darkgray;">{{ $v->cname }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group"> 
                <label for="thumb">缩略图</label> 
                <img data-src="holder.js/140x140" src="/uploads/{{ $data->thumb }}" alt="缩略图" class="img-thumbnail"  data-holder-rendered="true" style="width: 300px; height: 160px;">
                <input type="hidden" name="thumb_path" value="{{ $data->thumb }}">
                <input type="file" class="form-control" id="thumb" name="thumb" value="">
            </div>
            <div class="form-group">
                <label for="content">内容</label>  
                <!-- 加载编辑器的容器 -->
                <script id="content" name="content" type="text/plain">{!! $data->content !!}</script>
                <!-- 配置文件 -->
                <script type="text/javascript" src="/ueditor1_4_3_3-utf8-php/utf8-php/ueditor.config.js"></script>
                <!-- 编辑器源码文件 -->
                <script type="text/javascript" src="/ueditor1_4_3_3-utf8-php/utf8-php/ueditor.all.js"></script>
                <!-- 实例化编辑器 -->
                <script type="text/javascript">
                    var ue = UE.getEditor('content',{
                        toolbars: [
                            [
                                'undo', //撤销
                                'redo', //重做
                                'bold', //加粗
                                'indent', //首行缩进
                                'snapscreen', //截图
                                'italic', //斜体
                                'underline', //下划线
                                'strikethrough', //删除线
                                'subscript', //下标
                                'formatmatch', //格式刷
                                'source', //源代码
                                'pasteplain', //纯文本粘贴模式
                                'preview', //预览
                                'horizontal', //分隔线
                                'time', //时间
                                'date', //日期
                                'insertcode', //代码语言
                                'fontfamily', //字体
                                'fontsize', //字号
                                'paragraph', //段落格式
                                'simpleupload', //单图上传
                                'insertimage', //多图上传
                                'edittable', //表格属性
                                'link', //超链接
                                'emotion', //表情
                                'spechars', //特殊字符
                                'searchreplace', //查询替换
                            ],[
                                'help', //帮助
                                'justifyleft', //居左对齐
                                'justifyright', //居右对齐
                                'justifycenter', //居中对齐
                                'justifyjustify', //两端对齐
                                'forecolor', //字体颜色
                                'backcolor', //背景色
                                'insertorderedlist', //有序列表
                                'insertunorderedlist', //无序列表
                                'fullscreen', //全屏
                                'directionalityltr', //从左向右输入
                                'directionalityrtl', //从右向左输入
                                'rowspacingtop', //段前距
                                'rowspacingbottom', //段后距
                                'pagebreak', //分页
                                'attachment', //附件
                                'lineheight', //行间距
                                'edittip ', //编辑提示
                                'customstyle', //自定义标题
                                'autotypeset', //自动排版
                                'touppercase', //字母大写
                                'tolowercase', //字母小写
                                'background', //背景
                                'template', //模板
                                'scrawl', //涂鸦
                                'inserttable', //插入表格
                                'drafts', // 从草稿箱加载
                            ]
                        ]
                    });
                    
                </script>
            </div>
			<button type="submit" class="btn btn-default">修改</button>
        </form>
    </div>
</div>

@include('admin.layout.foot')
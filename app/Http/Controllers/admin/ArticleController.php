<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
class ArticleController extends Controller
{
	// 后台 文章 添加 显示
    public function create()
    {
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();

    	// 获取标签云数据
    	$tags = DB::table('tags')->orderBy('id','asc')->get();
    	// 获取栏目数据
    	$cates = CateController::cnamesList();
    	return view('admin.article.create',['tags'=>$tags,'cates'=>$cates,'admin_userinfo'=>$admin_userinfo]);
    }

	// 后台 文章 添加 操作
    public function store(Request $request)
    {
    	// 过滤垃圾数据
    	$this->validate($request, [
		    'title' => 'required|max:128',
		    'author' => 'required|max:32',
		    'desc' => 'required|max:255',
            'thumb' => 'max:128',
		    'content' => 'required',
		    'tid' => 'required',
		    'cid' => 'required',
		],[
			'title.required' => '文章标题不能为空',
		    'author.required' => '文章作者不能为空',
		    'desc.required' => '文章描述不能为空',
		    'content.required' => '文章内容不能为空',
		    'tid.required' => '标签ID不能为空',
		    'cid.required' => '栏目ID不能为空',
            'title.max' => '标题长度超出',
            'author.max' => '作者长度超出',
            'desc.max' => '描述长度超出',
            'thumb.max' => '缩略图长度超出',
		]);

    	// 验证图片并上传
    	if ($request->hasFile('thumb') && $request->file('thumb')->isValid()) {
    		$thumb = $request->file('thumb')->store(date('Ymd',time()));
    	} else {
    		$thumb = '';
    	}

    	// 接收数据
    	$data['title'] = $request->input('title','');
    	$data['author'] = $request->input('author','');
    	$data['desc'] = $request->input('desc','');
    	$data['content'] = $request->input('content','');
    	$data['tid'] = $request->input('tid',0);
    	$data['cid'] = $request->input('cid',0);
    	$data['thumb'] = $thumb;
    	$data['ctime'] = date('Y-m-d H:i:s',time());

    	// 插入数据 
    	$res = DB::table('articles')->insert($data);
    	if ($res) {
    		return redirect('/admin/article/index')->with('success','添加文章成功'); 
    	} else {
    		// 插入数据失败，删除缩略图
    		Storage::delete($data['thumb']);
    		return back()->with('error','添加文章失败');
    	}
    }

	// 后台 文章 列表 显示
    public function index(Request $request)
    {       
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();

    	// 搜索
    	$serach = $request->input('serach','');
    	// 查询标签数据
    	$tags = DB::table('tags')->get();
    	// 查询栏目数据
    	$cates = DB::table('cates')->get();
    	// 查询数据
    	$data = DB::table('articles')->paginate(5);
    	return view('admin.article.index',['data'=>$data,'tags'=>$tags,'cates'=>$cates,'serach'=>$serach,'admin_userinfo'=>$admin_userinfo]);
    }

	// 后台 文章 详情 显示
    public function show(Request $request)
    {
    	$id = $request->input('id',0);
    	$data = DB::table('articles')->where('id',$id)->first();
    	if ($data) {
    		echo json_encode($data);
    	} else {
    		echo json_encode(['msg'=>'error']);
    	}
    }

    // 后台 文章 修改 显示
    public function edit($id)
    {
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();

    	// 获取标签数据
    	$tags = DB::table('tags')->orderBy('id','asc')->get();
    	// 获取栏目数据
    	$cates = CateController::cnamesList();
    	// 获取文章数据
    	$data = DB::table('articles')->where('id',$id)->first();
    	return view('admin.article.edit',['data'=>$data,'tags'=>$tags,'cates'=>$cates,'admin_userinfo'=>$admin_userinfo]);
    }

    // 后台 文章 修改 操作
    public function update(Request $request,$id)
    {
    	// 过滤垃圾数据
    	$this->validate($request, [
		    'title' => 'required',
		    'author' => 'required',
		    'desc' => 'required',
		    'content' => 'required',
		    'tid' => 'required',
		    'cid' => 'required',
		],[
			'title.required' => '文章标题不能为空',
		    'author.required' => '文章作者不能为空',
		    'desc.required' => '文章描述不能为空',
		    'content.required' => '文章内容不能为空',
		    'tid.required' => '标签ID不能为空',
		    'cid.required' => '栏目ID不能为空'
		]);

		// 验证图片并上传
    	if ($request->hasFile('thumb') && $request->file('thumb')->isValid()) {
    		// 上传新图片路径
    		$thumb = $request->file('thumb')->store(date('Ymd',time()));
    	} else {
    		// 上传旧图片路径
    		$thumb = $request->input('thumb_path','');
    	}

    	// 接收数据
    	$data['title'] = $request->input('title','');
    	$data['author'] = $request->input('author','');
    	$data['desc'] = $request->input('desc','');
    	$data['content'] = $request->input('content','');
    	$data['tid'] = $request->input('tid',0);
    	$data['cid'] = $request->input('cid',0);
    	$data['thumb'] = $thumb;

    	// 更新数据 
    	$res = DB::table('articles')->where('id',$id)->update($data);
    	if ($res) {
    		// 上传新图片，删除旧图片
    		if ($thumb!=$request->input('thumb_path','')) {
    			Storage::delete($request->input('thumb_path',''));
    		}
			return redirect('/admin/article/index')->with('success','添加文章成功'); 
    	} else {
    		// 上传新图片，删除新图片
    		if ($thumb!=$request->input('thumb_path','')) {
    			Storage::delete($thumb);
    		}
    		return back()->with('error','添加文章失败');
    	}
    }

    // 后台 文章 删除 操作
    public function destory(Request $request)
    {

    	$id = $request->input('id',0);
    	$res = DB::table('articles')->where('id',$id)->delete();
    	if ($res) {
    		echo 'OK';
    	} else {
    		echo 'error';
    	}
    }
}

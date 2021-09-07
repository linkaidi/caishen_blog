<?php

namespace App\Http\Controllers\home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class SearchController extends Controller
{
    // 前台 搜索页 显示
    public function index(Request $request)
    {
    	$search = $request->input('search','');
    	// 获取栏目数据
    	$cates_data = IndexController::getCname();

        // 获取栏目名称数据
        $cateNames_data = IndexController::getCnames();

    	// 获取标签云数据
        $tag_data = DB::table('tags')->orderBy('id','asc')->get();

        // 默认每页显示5条
        $limit = $request->input('limit',5);
        // 起始页码为1
        $current_page = $request->input('page',1);
        // 每次跳过几条
        $skip = ($current_page-1) < 0 ? 0 : ($current_page-1)*$limit;
        // 文章实例
        $article_obj = DB::table('articles');
    	// 获取对应相关标题的文章
		$article_datas = $article_obj->where('title','like',"%{$search}%")->orderBy('ctime','desc')->get();
        // 文章分页
        $article_data = $article_obj->where('title','like',"%{$search}%")->orderBy('ctime','desc')->skip($skip)->take($limit)->get();
        // 文章数据总条数
        $total = $article_datas->count();

    	return view('home.search.index',['cates_data'=>$cates_data,'cateNames_data'=>$cateNames_data,'tag_data'=>$tag_data,'article_data'=>$article_data,'limit'=>$limit,'current_page'=>$current_page,'total'=>$total]);
    }
}

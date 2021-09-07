<?php

namespace App\Http\Controllers\home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redis;
class ListController extends Controller
{
    // 列表页 显示
    public function index($flag,$id,$cname = '',Request $request)
    {
    	// 获取栏目数据
    	$cates_data = IndexController::getCname();

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
    	// 获取对应的文章数据
        // 检测收到的是tid还是cid
        if ($flag == 'tid') {
            // 获取对应的标签名称
            foreach($tag_data as $tag){
                if ($tag->id == $id) {
                    $cname = $tag->tagname;
                }
            }
            // 获取对应栏目的文章数据
            $article_datas = $article_obj->where('tid',$id)->orderBy('ctime','desc')->get();
            // 文章分页数据
            $article_data = $article_obj->where('tid',$id)->orderBy('ctime','desc')->skip($skip)->take($limit)->get();
        } else if ($flag == 'cid') {
            // 获取对应标签的文章数据
            $article_datas = $article_obj->where('cid',$id)->orderBy('ctime','desc')->get();
            // 文章分页数据
            $article_data = $article_obj->where('cid',$id)->orderBy('ctime','desc')->skip($skip)->take($limit)->get();
        }
        // 文章数据总条数
        $total = $article_datas->count();

        // 获取栏目名称数据
        $cateNames_data = IndexController::getCnames();

    	return view('home.list.index',['cates_data'=>$cates_data,'article_data'=>$article_data,'cname'=>$cname,'tag_data'=>$tag_data,'cateNames_data'=>$cateNames_data,'current_page'=>$current_page,'limit'=>$limit,'total'=>$total]);
    }
}

<?php

namespace App\Http\Controllers\home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redis;
class IndexController extends Controller
{
	// 获取栏目数据
	public static function getCname()
	{
		$data = DB::table('cates')->orderBy('id','asc')->get();
		// 获取父级栏目数据
		foreach($data as $v){
			if ($v->pid==0) {
				$cates_parent[$v->id] = $v;
				$v->sub = [];
			}
		}

		// 压入子级栏目数据到父级栏目数据
		foreach($cates_parent as $key=>$cate_parent){
			foreach($data as $cate){
				if ($cate->pid==$key) {
					$cates_parent[$key]->sub[$cate->id] = $cate->cname;
				}
			}
		}

		// 整理后的栏目数据
		return $cates_parent;
	}

    // 获取栏目名称数据
    public static function getCnames()
    {
        $cateNames = DB::table('cates')->select('id','cname')->get();
        $cateNames_data = [];
        foreach($cateNames as $v){
            $cateNames_data[$v->id] = $v->cname;
        }
        return $cateNames_data;
    }

    // 前台 首页 显示
    public function index(Request $request)
    {
        if (Redis::exists('cates_redis_data')) {
            // 获取栏目redis数据
            $cates_data = json_decode(Redis::get('cates_redis_data'));
        } else {
        	// 获取栏目mysql数据
        	$cates_data = self::getCname(); 
            // 存入缓存
            Redis::setex('cates_redis_data',1800,json_encode($cates_data));    
        }

        if (Redis::exists('cateNames_redis_data')) {
            // 获取栏目名称redis数据
            $cateNames_data_str = json_decode(Redis::get('cateNames_redis_data'));
            // 将json转换成数组
            $cateNames_data = [];
            foreach($cateNames_data_str as $k=>$v){
                $cateNames_data[$k] = $v;
            }
            
        } else {
            // 获取栏目名称mysql数据
            $cateNames_data_obj = self::getCnames();
            // 将对象转换成数组
            $cateNames_data = (array)$cateNames_data_obj;
            // 存入缓存
            Redis::setex('cateNames_redis_data',1800,json_encode($cateNames_data));            
        }

        if (Redis::exists('banner_redis_data')) {
            // 获取轮播图redis数据
            $banner_data = json_decode(Redis::get('banner_redis_data'));
        } else {
            // 获取轮播图mysql数据
            $banner_data = DB::table('banners')->where('status',1)->orderBy('id','asc')->get();
            // 存入缓存
            Redis::setex('banner_redis_data',1800,json_encode($banner_data));   
        }    

        if (Redis::exists('tag_redis_data')) {
            // 获取标签云redis数据
            $tag_data = json_decode(Redis::get('tag_redis_data'));
        } else {
            // 获取标签云mysql数据
            $tag_data = DB::table('tags')->orderBy('id','asc')->get();
            // 存入缓存
            Redis::setex('tag_redis_data',1800,json_encode($tag_data));            
        }

        // 默认每页显示10条
        $limit = $request->input('limit',10);
        // 起始页码为1
        $current_page = $request->input('page',1);
        // 每次跳过几条
        $skip = ($current_page-1) < 0 ? 0 : ($current_page-1)*$limit;
        // 文章实例
        $article_obj = DB::table('articles');
        // 获取最新的10条数据
        $articles_datas = $article_obj->orderBy('ctime','desc')->get();
        // 文章数据总条数
        $total = $articles_datas->count();
    	// 获取最新的10条数据
    	$articles_data = $article_obj->orderBy('ctime','desc')->skip($skip)->take($limit)->get();

    	return view('home.index',['cates_data'=>$cates_data,'banner_data'=>$banner_data,'tag_data'=>$tag_data,'articles_data'=>$articles_data,'cateNames_data'=>$cateNames_data,'limit'=>$limit,'current_page'=>$current_page,'total'=>$total]);
    }
}

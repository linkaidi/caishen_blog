<?php

namespace App\Http\Controllers\home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class DetailController extends Controller
{
    /**
     * 获取上一篇文章数据
     *
     * @param  $aid int 文章ID 
     * @param  $cid int 栏目ID 
     * @return 返回上一篇文章数据
     */
    private static function articlePrev($aid,$cid)
    {   
        $data = DB::table('articles')->where('cid',$cid)->where('id','<',$aid)->orderBy('id','desc')->first();
        if ($data) {
            return $data;
        } else {
            return false;
        }
    } 

    /**
     * 获取下一篇文章数据
     *
     * @param  $aid int 文章ID 
     * @param  $cid int 栏目ID 
     * @return 返回下一篇文章数据
     */
    private static function articleNext($aid,$cid)
    {   
        $data = DB::table('articles')->where('cid',$cid)->where('id','>',$aid)->orderBy('id','asc')->first();
        if ($data) {
            return $data;
        } else {
            return false;
        }
    } 

    /**
     * 前台 文章 详情页 显示
     *
     * @param  $aid int 文章ID 
     * @param  $cid int 栏目ID 
     * @param  $cname string 栏目名称 
     * @return 渲染文章详情页模板
     */
    public function index($aid,$cid,$cname)
    {
		// 获取栏目数据
    	$cates_data = IndexController::getCname();
        // 获取当前栏目所属父栏目名称
        $cate_parent_name = '';
        foreach($cates_data as $cate){
            foreach($cate->sub as $k=>$v){
                if($cid == $k){
                    $cate_parent_name = $cate->cname;
                }
            }
        }

        // 文章阅读量+1
        DB::table('articles')->where('id',$aid)->increment('readnum',1);

    	// 获取对应文章数据
    	$article_data = DB::table('articles')->where('id',$aid)->first();
        if ($article_data==null) {
            return back();
        }

    	// 获取标签云数据
    	$tag_data = DB::table('tags')->orderBy('id','asc')->get();

        // 获取对应的标签tid
        $tid = $article_data->tid;
        // 获取对应的标签名称
        foreach($tag_data as $v){
            if ($tid==$v->id) {
                $tagname = $v->tagname;
            }
        }

        // 获取上一篇文章数据
        $article_prev_data = self::articlePrev($aid,$cid);
        // 获取下一篇文章数据
        $article_next_data = self::articleNext($aid,$cid);

    	return view('home.detail.index',['cates_data'=>$cates_data,'article_data'=>$article_data,'cname'=>$cname,'cid'=>$cid,'tag_data'=>$tag_data,'tagname'=>$tagname,'tid'=>$tid,'article_prev_data'=>$article_prev_data,'article_next_data'=>$article_next_data,'cate_parent_name'=>$cate_parent_name]);
    }

    /**
     * 前台 文章 详情页 点赞 ajax 操作
     *
     * @param  $request 文章ID
     * @return 返回json格式字符串
     */
    public function goodnum(Request $request)
    {
        // 获取文章aid
        $aid = $request->input('aid',0);

        // 检验用户是否登录
        if (session('home_login')) {
            // 获取登录用户uid
            $uid = session('home_userinfo')->id;
        } else {
            // 返回提示登录信息
            echo json_encode(['msg'=>'error','info'=>'请前往登录']);
            exit;
        }

        // 查询用户点赞的文章数据
        $aids_data = DB::table('users_articles')->where('uid',$uid)->select('aid')->get();
        // 将数据集合整理成数组
        $aids = [];
        foreach($aids_data as $k=>$v){
            $aids[$k] = $v->aid;
        }
        // 检验用户是否已给文章点过赞
        if (in_array($aid,$aids)) {
            // 已点赞
            // 返回已点赞信息
            echo json_encode(['msg'=>'error','info'=>'已点赞']);
            exit;
        }
        
        // 更新文章点赞数 +1
        $res = DB::table('articles')->where('id',$aid)->increment('goodnum',1);

        if ($res) {
            // 更新用户和文章关系表
            DB::table('users_articles')->insert(['uid'=>$uid,'aid'=>$aid]);
            // 返回点赞成功信息
            echo json_encode(['msg'=>'ok','info'=>'+1']);
            exit;
        } else {
            // 返回点赞失败信息
            echo json_encode(['msg'=>'error','info'=>'点赞失败']);
            exit;
        }
    }
}

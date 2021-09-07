<?php

namespace App\Http\Controllers\home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Captcha;
use DB;
use Hash;
class RegisterController extends Controller
{
    // 前台 注册 显示
    public function create()
    {
    	return view('home.register.create');
    }

    // 前台 注册 操作
    public function store(Request $request)
    {
    	// 验证数据
    	// 验证验证码
    	if (!Captcha::check($request->input('code'))) {
			echo json_encode(['msg'=>'error','info'=>'验证码错误']); 
			exit;
    	}

    	// 验证用户名
    	$uname = $request->input('uname','');
    	$uname_ptn = '/^[\w]{8,12}$/';
    	$res = preg_match($uname_ptn,$uname);
    	if ($res==0) {
			echo json_encode(['msg'=>'error','info'=>'用户名请输入8-12位数字字母下划线']); 
			exit;    		
    	}

    	// 验证用户名
    	$upass = $request->input('upass','');
    	$upass_ptn = '/^[\w]{8,12}$/';
    	$res = preg_match($upass_ptn,$upass);
    	if ($res==0) {
			echo json_encode(['msg'=>'error','info'=>'密码请输入8-12位数字字母下划线']); 
			exit;    		
    	}

    	// 验证两次密码一致性
    	$reupass = $request->input('reupass','');
    	if ($reupass!=$upass) {
			echo json_encode(['msg'=>'error','info'=>'两次密码不一致']); 
			exit;
    	}

    	// 整理数据
    	$data['uname'] = $uname;
    	$data['upass'] = Hash::make($upass);
    	$data['token'] = str_random(50);
    	$data['status'] = 0;
    	$data['ctime'] = date('Y-m-d H:i:s',time());

    	// 插入数据
    	$res = DB::table('users')->insert($data);
    	if ($res) {
    		echo json_encode(['msg'=>'ok','info'=>'注册成功']); 
			exit;
    	} else {
			echo json_encode(['msg'=>'error','info'=>'注册失败']); 
			exit;
    	}
    }

    
}

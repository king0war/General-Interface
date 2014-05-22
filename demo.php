<?php
include('config.php');

/**
实例化，发送通知
 */
$url = 'http://www.zhaotui.com/api/gi/client.php';  //需要通知的url
$data =  array (	'a' => '我是参数1' ,'b'=>'第二个参数' );  //参数
$notice = new gi_notice();		//实例化
echo $notice->sendNotice ( $url, 'test', $data);		//显示结果

/**
通过函数获取实例（单例模式），发送通知
 */
$url = 'http://www.zhaotui.com/api/gi/client.php';  //需要通知的url
$data =  array (	'a' => '我是参数1' ,'b'=>'第二个参数' );  //参数
$notice = gi_getNotice();		//获取实例
echo $notice->sendNotice ( $url, 'put', $data);		//显示结果


/**
 * 自定义调用
 */
$url = 'http://www.zhaotui.com/api/gi/client.php';  //需要通知的url
$data =  array (	'a' => '我是参数1' ,'b'=>'第二个参数' );  //参数
$notice = gi_getNotice();		//获取实例
//格式化数据
$data = $notice->gi_generalNotice('action', $data);
//发送通知
$notice->gi_sendNotice($url, $data, 'get');
echo $notice->sendNotice ( $url, 'put', $data);		//显示结果


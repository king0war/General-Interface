<?php
/**
 * General Interface客户端
 */
include_once('config.php');
$timestamp = $action = '';
$gi_post = $_REQUEST['gi'];
if( empty($gi_post) ){
	exit(' post data empty ');
}
$post = json_decode(gi_authcode2($gi_post) , true);
if( empty($post) ){
	$post = json_decode(gi_authcode($gi_post) , true);
}

if( empty( $post ) ){
	exit('string type error');
}
//处理编码
if( 'UTF-8' != GI_CHAR ){
	$post = gi_array_recursive($post, 'gi_char_convert','');
}
extract($post);
//验证是否过期
$timeOut = ( GI_TIMEOUT > 0 ) ? GI_TIMEOUT : 3600;
if( time() - $timestamp > $timeOut ){
	exit(' Authracation has expiried ');
}
if( empty($action) ){
	exit('action is empty');
}
if( !in_array($action , $whiteList) ){
	exit( $action . 'action not in the whiteList');
}
$gi_exec = gi_getExec();
if( GI_PARAMS_ARRAY ){
	$gi_exec->$action($data);
}else{
	call_user_func_array(array($gi_exec, $action) , $data);
}

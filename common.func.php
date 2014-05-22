<?php
/**
 * General Interface 函数库
 */

/**
 * UC经典加密函数
 *
 * @param string $string        	
 * @param string $operation
 *        	DECODE 解密 ENCODE 加密
 * @param string $key        	
 * @param number $expiry        	
 * @return string
 */
function gi_authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5 ( $key ? $key : GI_KEY );
	$keya = md5 ( substr ( $key, 0, 16 ) );
	$keyb = md5 ( substr ( $key, 16, 16 ) );
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr ( $string, 0, $ckey_length ) : substr ( md5 ( microtime () ), - $ckey_length )) : '';
	
	$cryptkey = $keya . md5 ( $keya . $keyc );
	$key_length = strlen ( $cryptkey );
	
	$string = $operation == 'DECODE' ? base64_decode ( substr ( $string, $ckey_length ) ) : sprintf ( '%010d', $expiry ? $expiry + time () : 0 ) . substr ( md5 ( $string . $keyb ), 0, 16 ) . $string;
	$string_length = strlen ( $string );
	
	$result = '';
	$box = range ( 0, 255 );
	
	$rndkey = array ();
	for($i = 0; $i <= 255; $i ++) {
		$rndkey [$i] = ord ( $cryptkey [$i % $key_length] );
	}
	
	for($j = $i = 0; $i < 256; $i ++) {
		$j = ($j + $box [$i] + $rndkey [$i]) % 256;
		$tmp = $box [$i];
		$box [$i] = $box [$j];
		$box [$j] = $tmp;
	}
	
	for($a = $j = $i = 0; $i < $string_length; $i ++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box [$a]) % 256;
		$tmp = $box [$a];
		$box [$a] = $box [$j];
		$box [$j] = $tmp;
		$result .= chr ( ord ( $string [$i] ) ^ ($box [($box [$a] + $box [$j]) % 256]) );
	}
	
	if ($operation == 'DECODE') {
		if ((substr ( $result, 0, 10 ) == 0 || substr ( $result, 0, 10 ) - time () > 0) && substr ( $result, 10, 16 ) == substr ( md5 ( substr ( $result, 26 ) . $keyb ), 0, 16 )) {
			return substr ( $result, 26 );
		} else {
			return '';
		}
	} else {
		return $keyc . str_replace ( '=', '', base64_encode ( $result ) );
	}
}
/**
 * 简单加密函数 兼容性良好 适用于各种环境
 *
 * @param string $string        	
 * @param string $operation
 *        	DECODE 解密 ENCODE 加密
 * @param string $key        	
 * @param number $expiry        	
 * @return string
 */
function gi_authcode2($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$key = sha1 ( $key ? $key : GI_KEY );
	if ($operation == 'DECODE') {
		$_start = ord ( substr ( $string, 0, 1 ) ) - 57 ;
		$key = md5(substr ( $key, $_start ). $_start . $key, TRUE);
		$string = substr ( $string,1);
		return str_replace ( $key, '', base64_decode ( $string ) );
	} else {
		$_start = mt_rand(8, 24);
		$key = md5( substr ( $key, $_start ). $_start .$key, TRUE);
		$_pre = chr ($_start + 57 );
		return $_pre . base64_encode ( $key . $string . $key ) ;
	}
}
/**
 * 字符传编码转换
 *
 * @param string $string        	
 * @param string $outChar        	
 * @param string $inChar        	
 * @return string
 */
function gi_char_convert($string, $outChar = '', $inChar = "UTF-8") {
	$outChar = $outChar ? $outChar : GI_CHAR;
	if ($outChar ==  GI_CHAR ) { // utf8不转换
		return $string;
	}
	if (function_exists ( 'iconv' )) { // 检测iconv是否可用 iconv效率高于mb，但兼容性稍差
		return iconv ( $inChar, $outChar . "//IGNORE", $string );
	}
	if (function_exists ( 'mb_convert_encoding' )) {
		return mb_convert_encoding ( $string, $outChar, $inChar );
	}
}
/**
 * 递归处理数组
 *
 * @param array $arr
 *        	需要处理的数组
 * @param string $func
 *        	需要调用的函数
 * @param array $args
 *        	其他参数 多个参数用数组封装
 * @return $arr 处理后的数组
 */
function gi_array_recursive($arr, $func, $args) {
	if (is_array ( $arr )) {
		foreach ( $arr as $k => $v ) {
			$arr [$k] = gi_array_recursive ( $v, $func, $args );
		}
	} else {
		if (is_array ( $args )) {
			array_unshift ( $args, $arr );
			$arr = call_user_func_array ( $func, $args );
		} else {
			$arr = $func ( $arr, $args );
		}
	}
	return $arr;
}
/**
 * curl模拟post提交
 *
 * @param string $url
 *        	目标url
 * @param sring $data
 *        	数据
 * @return string
 */
function gi_post($url, $data) {
	if (empty ( $url )) {		
		return false;
	}
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt ( $ch, CURLOPT_POST, true );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
	curl_setopt ( $ch, CURLOPT_HEADER, false );
	$result = curl_exec ( $ch );
	$curl_errno = curl_errno ( $ch );
	$curl_error = curl_error ( $ch );
	curl_close ( $ch );
	if ($curl_errno > 0) {
		return $curl_error;
	}
	return $result;
}
/**
 * 读取远程数据
 *
 * @param unknown $url
 *        	目标url
 * @param string $timeout
 *        	超时时间
 * @return string
 */
function gi_file_get_contents($url, $timeout = 30) {
	$opt = array (
			'http' => array (
					'method' => 'GET',
					'timeout' => $timeout 
			) 
	);
	$context = stream_context_create ( $opt );
	return file_get_contents ( $url, false, $context );
}
/**
 * 获取执行类实例
 */
function gi_getExec() {
	static $exec;
	if (is_null ( $exec )) {
		$exec = new gi_exec ();
	}
	return $exec;
}
function gi_getNotice(){
	static $notice;
	if(is_null( $notice ) ){
		$notice = new gi_notice();
	}
	return $notice;
}
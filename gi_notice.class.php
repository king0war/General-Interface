<?php
/**
 * gi接口，发送notice
 * @author ibrahim
 * 实例：
 * 
$url = 'http://www.shop.com/api/gi/client.php';  //需要通知的url
$data =  array (	'a' => 'Hello，中文测试'  );  //参数		
$notice = new gi_notice();		//实例化
echo $notice->sendNotice ( $url, 'test', $data);		//简单调用
 */

class gi_notice{
	/**
	 * 生成加密数据
	 *
	 * @param string $action
	 *        	方法名
	 * @param unknown $data
	 *        	参数数组
	 * @param string $key 加密密钥
	 * @param number $encryptType
	 *        	1 uc经典加密 2 gi加密
	 * @return string 加密后的字符串
	 */
	public function gi_generalNotice($action, $data, $key = '', $encryptType = 2) {
		if (empty ( $action ))
			return false;
		if (empty ( $key ))
			$key = GI_KEY;
		$encrypFun = ($encryptType == 2) ? 'gi_authcode2' : 'gi_authcode';
		$post = array (
				'action' => $action,
				'data' => $data,
				'timestamp' => time ()
		);
		if( 'UTF-8' != GI_CHAR ){
			$post = gi_array_recursive($post, 'gi_char_convert', array('UTF-8', GI_CHAR));
		}
		$json = json_encode ( $post );
		$string = $encrypFun ( $json, 'encode', $key );
		if ($string) {
			return $string;
		}
		return false;
	}
	
	/**
	 * 发送通知
	 *
	 * @param sting $url 需要通知的url
	 * @param sting $data
	 *        	加密后的参数
	 * @param string $method post、get方法
	 * @return string 通知返回的结果
	 */
	public function gi_sendNotice($url, $data, $method = 'post') {
		if (empty ( $url ))
			return false;
		$string = 'gi=' . urlencode ( $data );
		if ($method == 'post') {
			$result = gi_post ( $url, $string );
		} else {
			$result = gi_file_get_contents ( $url . '?' . $string );
		}
		return $result;
	}
	/**
	 * 快速发送通知
	 * @param string $url 目标url
	 * @param string $action 操作
	 * @param array $data 参数
	 * @return 
	 */
	public function sendNotice($url, $action, $data){
		if( empty($url) ){
			return 'Url not Exists';
		}
		$data = $this->gi_generalNotice($action, $data);
		if( empty($data) ){
			return ' General Data Error';
		}
		return $this->gi_sendNotice($url, $data);
	}
}
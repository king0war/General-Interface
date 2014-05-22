<?php
/**
 * General Interface	接口执行类
 * @author Ibrahim
 *
 */
class gi_exec {
	public $db;	//引入外部db操作类
	
	public function __construct(){		
	}
	/**
	 * 测试函数
	 */
	public function test(){
		echo 'Testing..  Params:<br/>';
		print_r(func_get_args());
	}
	/**
	 * 新增数据
	 * @param unknown $data
	 */
	public function post($data){
		print_r(func_get_args());
	}
	/**
	 * 更新数据
	 * @param array $data	
	 */
	public function put($data){
		print_r($data);
	}
	/**
	 * 查询数据
	 */
	public function get($data){
		
	}
	/**
	 * 删除数据
	 * @param unknown $data
	 */
	public function delete($data){
		print_r(func_get_args());
	}
	
}
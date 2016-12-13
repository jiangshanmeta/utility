<?
defined('BASEPATH') OR exit('No direct script access allowed');
// 这个类是对CI_Model的拓展
class H_Model extends CI_Model{
	static private $_cache_models;
	public function __construct(){
		parent::__construct();
	}

	// 之所以有这个方法是业务逻辑复杂化之后向model层进行封装，有在model层对其他model进行操作的需求
	// 为了防止冗余实例化,尤其是在循环中实例化类
	// 这里实现的是单例
	final protected function get_model($model){
		$_cache_name = strtolower($model);
		if(!isset(self::$_cache_models[$_cache_name]) || !(self::$_cache_models[$_cache_name] instanceof $model) ){
			self::$_cache_models[$_cache_name] = new $model;
		}
		return self::$_cache_models[$_cache_name];
	}

	// 为了子类中获得孙子类(最终类)的类名，进而使用孙子类(最终类)的静态属性
	final protected function get_submodel_name(){
		return get_class($this);
	}

}
?>
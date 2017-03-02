<?
// 因为业务逻辑逐渐复杂化，controller和model层之间加一个service层
class CI_Service{
	protected $CI;
	function __construct(){
		$this->CI = &get_instance();
	}
	public function __get($key){
		return get_instance()->$key;
	}
}
?>
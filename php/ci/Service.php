<?
// 因为业务逻辑逐渐复杂化，controller和model层之间加一个service层
class CI_Service{
	function __construct(){
		
	}
	public function __get($key){
		return get_instance()->$key;
	}
}
?>
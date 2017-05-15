<?
class Menu{
	protected $_all_menus;
	function __construct($config = array()){
		if(!empty($config)){
			$this->set_all_menus($config);
		}
	}

	// 把具体的菜单写到一个config文件里而不是写到library类里面更合适
	function set_all_menus($config){
		if(is_array($config)){
			$this->_all_menus = $config;
		}
	}

	function load_menu(){
		// 具体的根据业务逻辑来写,还有权限之类的

		return $this->_all_menus;
	}
}
?>
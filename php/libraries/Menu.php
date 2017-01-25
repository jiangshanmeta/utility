<?
class Menu{
	private $all_menus;
	function __construct(){
		$this->all_menus = [];
	}

	// 加载全部菜单
	function _load_all_menus(){
		$this->all_menus['index'] = [
			'sub_menus'=>[
				'index'=>[
					'href'=>'http://jiangshanmeta.github.io',
					'name'=>'首页',
				]
			],
			'name'=>'首页',
			'icon'=>'naive',
		];


	}

	function load_menu(){
		// 具体的根据业务逻辑来写
		$this->_load_all_menus();
		return $this->all_menus;
	}
}
?>
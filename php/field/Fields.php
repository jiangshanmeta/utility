<?
class Fields{
	static protected $_emun_pool = [];
	protected $showName;
	protected $name;
	protected $isMustInput;
	public $value;
	public $default;
	static $_enum_pool = [];
	function __construct($showName,$name,$isMustInput=FALSE){
		$this->showName = $showName;
		$this->name = $name;
		$this->isMustInput = $isMustInput;
	}
	public function init($value){
		$this->value = $value;
	}
	public function gen_value($input){
		return $input;
	}
	public function setDefault($value){
		$this->default = $value;
	}
	public function gen_show_value(){
		return $this->value;
	}

	public function gen_show_name(){
		return $this->showName;
	}
	public function gen_vm_value(){
		return $this->gen_show_value();
	}
}

?>
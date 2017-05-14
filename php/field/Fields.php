<?
class Fields{
	// 统一成下划线命名
	// 属性在前，方法在后
	// 静态在前，实例在后
	// 公有在前，私有在后
	static protected $_cache_enum = [];
	static protected $_cache_model = [];

	public $tips;
	public $value;
	public $default;
	public $typ;

	protected $show_name;
	protected $name;
	protected $is_must_input;
	protected $editor_class;

	public function __construct($show_name,$name,$is_must_input=FALSE){
		$this->show_name = $show_name;
		$this->name = $name;
		$this->is_must_input = $is_must_input;
	}
	public function gen_show_name(){
		return $this->show_name;
	}

	public function init($value){
		$this->value = $this->gen_value($value);
	}
	public function gen_value($input){
		return $input;
	}
	public function set_default($value){
		$this->default = $this->gen_value($value);
	}
	public function gen_show_value(){
		return $this->value;
	}
	public function gen_vm_value(){
		return $this->gen_show_value();
	}

	public function gen_editor($typ){

	}
	final public function build_input_name($typ){
		switch ($typ) {
			case 0:
				$input_name = 'create_'.$this->name;
				break;
			case 1:
				$input_name = 'modify_'.$this->name;
				break;
			case 2:
				$input_name = 'search_'.$this->name;
			default:
				$input_name = $this->name;
				break;
		}
		return $input_name;
	}
	final public function set_editor_class($class_name){
		$this->editor_class = $class_name;
	}
}
?>
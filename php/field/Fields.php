<?
class Fields{
	protected $showName;
	protected $name;
	protected $isMustInput;
	protected $editorClass;
	public $tips;
	public $value;
	public $default;
	static protected $_cache_model = [];
	function __construct($showName,$name,$isMustInput=FALSE){
		$this->showName = $showName;
		$this->name = $name;
		$this->isMustInput = $isMustInput;
	}
	public function init($value){
		$this->value = $this->gen_value($value);
	}
	public function gen_value($input){
		return $input;
	}
	public function setDefault($value){
		$this->default = $this->gen_value($value);
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

	final function build_input_name($typ){
		switch ($typ) {
			case 0:
				$inputName = 'create_'.$this->name;
				break;
			case 1:
				$inputName = 'modify_'.$this->name;
				break;
			case 2:
				$inputName = 'search_'.$this->name;
			default:
				$inputName = $this->name;
				break;
		}
		return $inputName;
	}
	function gen_editor($typ){

	}

	final function setEditorClass($className){
		$this->editorClass = $className;
	}
}
?>
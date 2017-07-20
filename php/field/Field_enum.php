<?
require_once('Field_int.php');
class Field_enum extends Field_int{
	public $enum;
	public $enum_reverse;
	public $can_select;	
	protected $_enum_key;

	public function __construct($show_name,$name,$is_must_input=FALSE,$table_name=''){
		parent::__construct($show_name,$name,$is_must_input);
		if($table_name!=''){
			$this->set_enum_key($table_name.'_'.$name);			
		}
		$this->typ = 'Field_enum';
	}

	public function gen_enum_config(){
		$data = [];
		foreach ($this->enum as $key => $value) {
			$data[] = [
				'value'=>$key,
				'label'=>$value,
			];
		}
		return $data;
	}

	public function gen_value($input){
		$input = parent::gen_value($input);
		if(!in_array($input, $this->can_select)){
			$input = $this->can_select[0];
		}
		return $input;
	}

	public function gen_show_value(){
		return $this->enum[$this->value];
	}

	public function set_enum_key($key){
		$this->_enum_key = $key;
	}
	public function set_enum($enum){
		if($this->_enum_key){
			if(!isset(self::$_cache_enum[$this->_enum_key]['enum'])){
				self::$_cache_enum[$this->_enum_key]['enum'] = $enum;
				self::$_cache_enum[$this->_enum_key]['flip'] = array_flip($enum);
				self::$_cache_enum[$this->_enum_key]['keys'] = array_keys($enum);
			}
			$this->enum = & self::$_cache_enum[$this->_enum_key]['enum'];
			$this->enum_reverse = & self::$_cache_enum[$this->_enum_key]['flip'];
			$this->can_select = & self::$_cache_enum[$this->_enum_key]['keys'];
		}else{
			$this->enum = $enum;
			$this->enum_reverse = array_flip($enum);
			$this->can_select = array_keys($enum);
		}
		$this->set_default($this->can_select[0]);
	}

	public function gen_editor($typ){
		switch ($typ) {
			case 0:
				$value = $this->gen_value($this->default);
				break;
			case 1:
				$value = $this->value;
				break;
			default:
				$value = $this->gen_value($this->default);
				break;
		}
		$input_name = $this->build_input_name($typ);
		$string = "<select class=\"$this->editor_class\" value=\"$value\" name=\"$input_name\"  id=\"$input_name\"    >";
		foreach ($this->enum as $key => $this_enum) {
			$string .= "<option ".($key==$value?'selected':'')." value=\"$key\" >$this_enum</option>";
		}
		$string .= "</select>";
		return $string;
	}


}
?>
<?
require_once('Field_array.php');
class Field_tag extends Field_array{
	public $enum;
	public $can_select = [];
	
	protected  $_enum_key;

	public function __construct($show_name,$name,$is_must_input=FALSE,$table_name=''){
		parent::__construct($show_name,$name,$is_must_input);
		if($table_name!=''){
			$this->set_enum_key($table_name.'_'.$name);
		}
		$this->typ = 'Field_tag';
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

	
	public function set_enum($enum){
		if($this->_enum_key){
			if(!isset(self::$_cache_enum[$this->_enum_key]['enum'])){
				self::$_cache_enum[$this->_enum_key]['enum'] = $enum;
				self::$_cache_enum[$this->_enum_key]['keys'] = array_keys($enum);
			}
			$this->enum = &self::$_cache_enum[$this->_enum_key]['enum'];
			$this->can_select = &self::$_cache_enum[$this->_enum_key]['keys'];
		}else{
			$this->enum = $enum;
			$this->can_select = array_keys($enum);
		}
	}
	public function set_enum_key($key){
		$this->_enum_key = $key;
	}

	public function gen_value($input){
		$input = parent::gen_value($input);
		foreach ($input as $key => $value) {
			$input[$key] = (int)$value;
		}
		$input = array_values(array_intersect($this->can_select, $input));
		return $input;
	}

	public function setFull(){
		$this->value = &$this->can_select;
	}

	public function has($input){
		return in_array($input, $this->value);
	}


}
?>
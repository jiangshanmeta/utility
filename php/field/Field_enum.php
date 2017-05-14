<?
require_once('Field_int.php');
class Field_enum extends Field_int{
	protected $_enum_pool_key;
	public $enum;
	public $enumReverse;
	public $can_select;
	function __construct($showName,$name,$isMustInput=FALSE,$tableName=''){
		parent::__construct($showName,$name,$isMustInput);
		if($tableName!=''){
			$this->setEnumPoolKey($tableName.'_'.$name);			
		}
		$this->typ = 'Field_enum';
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

	public function setEnumPoolKey($key){
		$this->_enum_pool_key = $key;
	}
	public function setEnum($enum){
		if($this->_enum_pool_key){
			if(!isset(self::$_cache_enum[$this->_enum_pool_key]['enum'])){
				self::$_cache_enum[$this->_enum_pool_key]['enum'] = $enum;
				self::$_cache_enum[$this->_enum_pool_key]['flip'] = array_flip($enum);
				self::$_cache_enum[$this->_enum_pool_key]['keys'] = array_keys($enum);
			}
			$this->enum = & self::$_cache_enum[$this->_enum_pool_key]['enum'];
			$this->enumReverse = & self::$_cache_enum[$this->_enum_pool_key]['flip'];
			$this->can_select = & self::$_cache_enum[$this->_enum_pool_key]['keys'];
		}else{
			$this->enum = $enum;
			$this->enumReverse = array_flip($enum);
			$this->can_select = array_keys($enum);
		}
		$this->setDefault($this->can_select[0]);
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
		$inputName = $this->build_input_name($typ);
		$string = "<select class=\"$this->editorClass\" value=\"$value\" name=\"$inputName\"  id=\"$inputName\"    >";
		foreach ($this->enum as $key => $this_enum) {
			$string .= "<option ".($key==$value?'selected':'')." value=\"$key\" >$this_enum</option>";
		}
		$string .= "</select>";
		return $string;
	}


}
?>
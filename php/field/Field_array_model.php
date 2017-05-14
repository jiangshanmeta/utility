<?php
require_once('Field_array_mongoid.php');
class Field_array_model extends Field_array_mongoid{
	static protected $_cache = [];
	public $real_value = [];
	protected $_model_name;
	protected $_show_field;
	function __construct($showName,$name,$isMustInput=FALSE,$modelName=''){
		parent::__construct($showName,$name,$isMustInput);
		if($modelName!==''){
			$this->set_model_name($modelName);
		}
	}

	function set_model_name($modelName){
		$this->_model_name = $modelName;
	}

	function set_show_field($showField){
		$this->_show_field = $showField;
	}

	function init($value){
		parent::init($value);
		if(empty($this->_model_name)){
			return;
		}
		$modelName = $this->_model_name;
		foreach ($this->value as $mongoid) {
			if(!isset(self::$_cache[$modelName][$mongoid])){
				self::$_cache[$modelName][$mongoid] = new $modelName;
				self::$_cache[$modelName][$mongoid]->init_with_id($mongoid);
			}
			$this->real_value[$mongoid] = &self::$_cache[$modelName][$mongoid];
		}
	}

	function gen_show_value(){
		$rst = [];
		foreach ($this->real_value as $this_model) {
			$rst[] = $this_model->field_list[$this->_show_field]->gen_show_value();
		}
		return implode(",",$rst);
	}

}
?>
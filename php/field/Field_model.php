<?php
require_once('Field_mongoid.php');
class Field_model extends Field_mongoid{
	public $real_value;
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
		if(!MongoId::isValid($this->value)){
			return;
		}
		if(empty($this->_model_name)){
			return;
		}
		$modelName = $this->_model_name;
		if(!isset(self::$_cache_model[$modelName][$this->value])){
			self::$_cache_model[$modelName][$this->value] = new $modelName;
			self::$_cache_model[$modelName][$this->value]->init_with_id($this->value);
		}
		$this->real_value = &self::$_cache_model[$modelName][$this->value];
	}

	function gen_show_value(){
		return $this->real_value->field_list[$this->_show_field]->gen_show_value();
	}


}

?>
<?php
require_once('Field_mongoid.php');
class Field_model extends Field_mongoid{
	public $real_value;
	protected $_model_name;
	protected $_show_field;
	protected $_enum = array();
	public function __construct($show_name,$name,$is_must_input=FALSE,$model_name=''){
		parent::__construct($show_name,$name,$is_must_input);
		if($model_name!==''){
			$this->set_model_name($model_name);
		}
	}

	public function set_model_name($model_name){
		$this->_model_name = $model_name;
	}

	public function set_show_field($showField){
		$this->_show_field = $showField;
	}

	public function init($value){
		parent::init($value);
		if(!MongoId::isValid($this->value)){
			$this->real_value = NULL;
			return;
		}
		if(empty($this->_model_name)){
			return;
		}
		$model_name = $this->_model_name;
		if(!isset(self::$_cache_model[$model_name][$this->value])){
			self::$_cache_model[$model_name][$this->value] = new $model_name;
			self::$_cache_model[$model_name][$this->value]->init_with_id($this->value);
		}
		$this->real_value = &self::$_cache_model[$model_name][$this->value];
	}

	public function gen_show_value(){
		if($this->real_value instanceof $this->_model_name){
			return $this->real_value->field_list[$this->_show_field]->gen_show_value();
		}
		return $this->value;
	}

	public function set_enum(){

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

}

?>
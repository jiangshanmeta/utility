<?php
require_once('Field_array_mongoid.php');
class Field_array_model extends Field_array_mongoid{
	public $real_value = [];
	protected $_model_name;
	protected $_show_field;
	protected $_enum = array();
	function __construct($show_name,$name,$is_must_input=FALSE,$model_name=''){
		parent::__construct($show_name,$name,$is_must_input);
		if($model_name!==''){
			$this->set_model_name($model_name);
		}
	}

	final public function set_model_name($model_name){
		$this->_model_name = $model_name;
	}

	final public function set_show_field($showField){
		$this->_show_field = $showField;
	}

	public function init($value){
		parent::init($value);
		if(empty($this->_model_name)){
			return;
		}
		$model_name = $this->_model_name;
		$this->real_value = [];
		foreach ($this->value as $mongoid) {
			if(!isset(self::$_cache_model[$model_name][$mongoid])){
				self::$_cache_model[$model_name][$mongoid] = new $model_name;
				self::$_cache_model[$model_name][$mongoid]->init_with_id($mongoid);
			}
			$this->real_value[$mongoid] = &self::$_cache_model[$model_name][$mongoid];
		}
	}

	public function gen_show_value(){
		$rst = [];
		foreach ($this->real_value as $this_model) {
			$rst[] = $this_model->field_list[$this->_show_field]->gen_show_value();
		}
		return implode(",",$rst);
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
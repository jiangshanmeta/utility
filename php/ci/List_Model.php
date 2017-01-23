<?
defined('BASEPATH') OR exit('No direct script access allowed');
class List_Model extends H_Model{
	public $record_list = [];
	public $record_count = 0;
	public $data = [];
	public $dataModelName;
	public $dataModel;
	public $tableName;
	public $limit = 2000;
	public $skip = 0;
	public $orderBy = ['_id'=>'desc'];
	public $whereData = [];
	public $will_init_record = true;
	public function __construct(){
		parent::__construct();
	}
	final public function add_where($typ,$name,$data){
		$this->whereData[] = ['typ'=>$typ,'name'=>$name,'data'=>$data];
	}
	final public function load_data(){
		$this->_restrict();
		$this->_getData();
	}
	final public function load_data_with_where(){
		$this->_checkWhere();
		$this->_restrict();
		$this->_getData();
	}
	public function load_data_with_orignal_where(array $where_array){
		$this->db->where($where_array, TRUE);
		$this->_restrict();
		$this->_getData();
	}
	private function _restrict(){
		if($this->limit>0){
			$this->db->limit($this->limit);
		}
		if($this->skip>0){
			$this->db->skip($this->skip);
		}

		$this->db->order_by($this->orderBy);		
	} 
	private function _getData(){
		$query = $this->db->get($this->tableName);
		$this->record_count = $query->num_rows();
		if($this->record_count>0){
			$this->_serializeData($query);
		}
	}
	private function _serializeData($query){
		foreach ($query->result_array() as $row) {
			$id = (string)$row['_id'];
			if($this->will_init_record){
				$this->record_list[$id] = new $this->dataModelName();
				$this->record_list[$id]->init_with_data($id,$row);
			}
			$this->data[$id] = $row;
		}
		unset($query);
	}	
	final protected function _checkWhere(){
		foreach ($this->whereData as $this_where) {
			$typ = $this_where['typ'];
			$name = $this_where['name'];
			$data = $this_where['data'];
			switch ($typ) {
				case WHERE_TYPE_WHERE:
					$this->db->where([$name=>$data]);
					break;
				case WHERE_TYPE_WHERE_NE:
					$this->db->where_ne($name,$data);
					break;				
				case WHERE_TYPE_IN:
					$this->db->where_in($name,$data);
					break;
				case WHERE_TYPE_NOT_IN:
					$this->db->where_not_in($name,$data);
					break;
				case WHERE_TYPE_WHERE_GT:
					$this->db->where_gt($name,$data);
					break;
				case WHERE_TYPE_WHERE_LT:
					$this->db->where_lt($name,$data);
					break;
				case WHERE_TYPE_WHERE_GTE:
					$this->db->where_gte($name,$data);
					break;
				case WHERE_TYPE_WHERE_LTE:
					$this->db->where_lte($name,$data);
					break;
				case WHERE_TYPE_LIKE:
					$this->db->like($name,$data,'iu');
					break;
				default:
					# code...
					break;
			}
		}
	}
	final public function init($dataModelName){
		$this->dataModelName = $dataModelName;
		$this->dataModel = new $dataModelName();
		$this->tableName = $this->dataModel->tableName;
	}
	final public function update_batch($data){
		$this->_checkWhere();
		$this->db->update_batch($this->tableName,$data);
	}
	final public function delete_batch(){
		$this->_checkWhere();
		$this->db->delete_batch($this->tableName);
	}
	final public function reset(){
        $this->db->clear();
        $this->data = [];
        $this->record_list = [];
        $this->whereData = [];
        $this->record_count = 0;
        $this->skip = 0;
        $this->limit = 2000;
        $this->orderBy = ['_id'=>'desc'];
	}
	final public function count_data(){
		$this->db->clear();
		$count = $this->db->count_all_results($this->tableName);
		$this->db->clear();
		return $count;
	}
	final public function count_data_with_where(){
		$this->db->clear();
		$this->_checkWhere();
		$count = $this->db->count_all_results($this->tableName);
		$this->db->clear();
		return $count;
	}
	function gen_vm_array(array $arr,array $org_arr = [],$prefix='org_'){
		$rst = [];
		foreach ($this->record_list as $this_record) {
			$rst[] = $this_record->gen_vm_data($arr,$org_arr,$prefix);
		}
		return $rst;
	}
	function gen_vm_hash(array $arr,array $org_arr = [],$prefix='org_'){
		$rst = [];
		foreach ($this->record_list as $this_record) {
			$rst[$this_record->id] = $this_record->gen_vm_data($arr,$org_arr,$prefix);
		}
		return $rst;
	}
    function mapReduce($opt){
        $commandArr = [
            'mapreduce'=>$this->tableName,
            'map'=>$opt['map'],
            'reduce'=>$opt['reduce'],
            'out'=>['inline'=>1],
        ];
        isset($opt['query']) && $commandArr['query'] = $opt['query'];
        isset($opt['sort']) && $commandArr['sort'] = $opt['sort'];
        isset($opt['limit']) && $commandArr['limit'] = $opt['limit'];

        $rst = $this->db->command($commandArr);

        return $rst['results'];
    }

    final public function gen_id_array($is_object = false){
    	if($is_object){
    		$rst = [];
    		foreach ($this->record_list as $key => $value) {
    			$rst[] = new MongoId($key);
    		}
    		return $rst;
    	}else{
    		return array_keys($this->record_list);
    	}
    }

	
}
?>
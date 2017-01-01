<?
require_once('doublyLinkedList.php');
class H_Queue extends H_DoublyLinkedList{
	function __construct(){
		parent::__construct();
		$this->setIteratorMode();
	}
	function setIteratorMode($mode=''){
		parent::setIteratorMode(self::IT_MODE_FIFO);
	}
	function enqueue($data){
		$this->push($data);
	}
	function dequeue(){
		return $this->unshift();
	}
}
?>
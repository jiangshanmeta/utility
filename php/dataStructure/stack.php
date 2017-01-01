<?
require_once('doublyLinkedList.php');
class H_Stack extends H_DoublyLinkedList{
	function __construct(){
		parent::__construct();
		$this->setIteratorMode();
	}
	function setIteratorMode($mode=''){
		parent::setIteratorMode(self::IT_MODE_LIFO);
	}
}
?>
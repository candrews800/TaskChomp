<?php

class TaskList extends DatabaseObject{

	protected static $table_name="TaskList";
	protected static $list_item_table_name="Item";
	public static $db_fields = array('id', 'user_id', 'category_id', 'date', 'title', 'status', 'unfinished', 'edit');
	public $id;
	public $user_id;
	public $category_id;
	public $date;
	public $title;
	public $status;
	public $unfinished;
	public $edit;

	public function delete(){
		global $db;
		
		// Delete All related List Items as well as the List
		parent::delete();
		
		$sql = "DELETE FROM ".self::$list_item_table_name;
		$sql.= " WHERE list_id=".$this->id;
		
		$db->query($sql);
	}
	
	public static function get_status($list_id){
		global $db;
		
		$sql = "SELECT *
				FROM Item
				WHERE list_id = {$list_id}
				AND status = 0
				LIMIT 1";
		
		$result = $db->query($sql);
		$has_item_complete = $result->num_rows;
		
		$sql = "SELECT *
				FROM Item
				WHERE list_id = {$list_id}
				AND status = 1
				LIMIT 1";
				
		$result = $db->query($sql);
		$has_item_incomplete = $result->num_rows;
		
		$tasklist = self::find_by_id($list_id);
		
		if(!empty($has_item_complete) && !empty($has_item_incomplete)){
			// In Progress
			$tasklist->status = 1;
			$tasklist->update();
			return 1;
		}
		else if(!empty($has_item_complete)){
			// Complete
			$tasklist->status = 0;
			$tasklist->update();
			return 0;
		}
		else{
			// Not Started
			$tasklist->status = 2;
			$tasklist->update();
			return 2;
		}
	}
	
	public function update_finished_amt($finished){
		if($finished){
			$this->unfinished++;
		}
		else{
			$this->unfinished--;
			if($this->unfinished < 0){
				$this->unfinished = 0;
			}
		}
		$this->update();
		self::get_status($this->id);
		
		return $this->unfinished;
	}
	
	public function toggle_edit(){
		if($this->edit == 0){
			$this->edit = 1;
		}
		else{
			$this->edit = 0;
		}
		
		$this->update();
	}
	
}

?>
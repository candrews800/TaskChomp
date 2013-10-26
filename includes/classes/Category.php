<?php

class Category extends DatabaseObject{

	protected static $table_name="Category";
	public static $db_fields = array('id', 'user_id', 'title', 'unfinished', 'order_id');
	public $id;
	public $user_id;
	public $title;
	public $unfinished;
	public $order_id;
	
	public static function lists_by_category($user_id = 0, $category = 0){
		return parent::find_all("user_id",$user_id, "category", $list_id);		
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
		
		return $this->unfinished;
	}
	
	public function delete_list_unfinished($list_id){
		global $db;
		
		// Deletes Amount of Unfinished Items in the given list Id
		
		$sql = "SELECT * FROM Item WHERE list_id={$list_id} AND status=1";
		
		$result = $db->query($sql);
		
		$this->unfinished -= $result->num_rows;
		
		$this->update();
	}
}

?>
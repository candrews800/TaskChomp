<?php

class Item extends DatabaseObject{

	protected static $table_name="Item";
	public static $db_fields = array('id', 'user_id', 'list_id', 'order_id', 'title', 'date', 'status');
	public $id;
	public $user_id;
	public $list_id;
	public $order_id;
	public $title;
	public $date;
	public $status;
	
	// Array of Related SubItems
	public $subitems;
	
	public static function get_list_items($user_id = 0, $list_id = 0){
		return self::find_all("user_id",$user_id, "list_id", $list_id, "order_id", "ASC");		
	}

	public function toggle_status(){
		if($this->status == 0){
			$this->status = 1;
		}
		else{
			$this->status = 0;
		}
		
		return $this->update();
	}
	
	public function move($position){
		global $db;
		$prev_position = $this->order_id;
		
		if($prev_position > $position){
			for($i=$prev_position-1; $i >= $position; $i--){
				// Increment order_id by 1 for all positions
				$sql = "UPDATE ". static::$table_name;
				$sql.=" SET order_id = order_id+1";
				$sql.=" WHERE list_id=".$this->list_id;
				$sql.=" AND order_id=".$i;
				
				$db->query($sql);
			}
					
			$sql = "UPDATE ".static::$table_name;
			$sql.=" SET order_id=".$position;
			$sql.=" WHERE id=".$this->id;

			return $db->query($sql);
		}
		else if($position == 0){
			$sql = "UPDATE ".static::$table_name;
			$sql.=" SET order_id=order_id -1";
			$sql.=" WHERE order_id=1";
			
			$db->query();
			
			$sql = "UPDATE ".static::$table_name;
			$sql.=" SET order_id=".$position;
			$sql.=" WHERE id=".$this->id;

			return $db->query($sql);
		}
		else{
			for($i=$prev_position+1; $i <= $position; $i++){
				// Increment order_id by 1 for all positions
				$sql = "UPDATE ". static::$table_name;
				$sql.=" SET order_id = order_id-1";
				$sql.=" WHERE list_id=".$this->list_id;
				$sql.=" AND order_id=".$i;
				
				$db->query($sql);
			}
					
			$sql = "UPDATE ".static::$table_name;
			$sql.=" SET order_id=".$position;
			$sql.=" WHERE id=".$this->id;

			return $db->query($sql);
		}
	}
}

?>
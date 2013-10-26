<?php

class SubItem extends DatabaseObject{

	protected static $table_name="SubItem";
	public static $db_fields = array('id', 'item_id', 'user_id', 'order_id', 'title', 'status');
	public $id;
	public $item_id;	
	public $user_id;
	public $order_id;
	public $title;
	public $status;	

	public static function subitems_from_item($user_id=0, $item_id=0){
		return self::find_all("user_id",$user_id, "item_id", $item_id, "order_id", "ASC");	
	}

	public function toggle_status(){
		if($this->status == 1){
			$this->status = 0;
		}
		else{
			$this->status = 1;
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
				$sql.=" WHERE item_id=".$this->item_id;
				$sql.=" AND order_id=".$i;
				
				$db->query($sql);
			}
					
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
				$sql.=" WHERE item_id=".$this->item_id;
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
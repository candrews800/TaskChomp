<?php

class DatabaseObject{

	public static function find_by_id($id=0){
		global $db;
		$result = $db->query("SELECT * FROM ".static::$table_name." WHERE id={$id} LIMIT 1");
		
		if(!$db->confirm_query($result) || $result->num_rows < 1){
			return false;
		}
		
		$record = array();
		$record = $result->fetch_array(MYSQLI_ASSOC);
		
		return self::initialize($record);
	}
	
	public static function find_all($col="", $value="", $col2="", $value2="", $sort_by="", $sort_dir=""){
		global $db;
		$where_clause = "";
		if($col!="" && $value!=""){
			$where_clause = " WHERE {$col} = '{$value}'";
			if($col2!="" && $value2!=""){
				$where_clause .= " AND {$col2} = '{$value2}'";
			}
		}
		$sort_sql = "";
		if($sort_by != "" && $sort_dir != ""){
			$sort_sql = " ORDER BY ".$sort_by." ".$sort_dir;
		}
		$result = $db->query("SELECT * FROM ".static::$table_name.$where_clause.$sort_sql);
		if(!$db->confirm_query($result)){
			return false;
		}
		
		$records = array();
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$records[] = self::initialize($row);
		}
		
		return $records;
	}
	
	public static function initialize($records){
		$called_class = get_called_class();
		$object = new $called_class;
		
		$keys = array_keys($records);
		
		foreach($keys as $attribute){
			if(array_key_exists($attribute, get_object_vars($object))){
				$object->$attribute = $records[$attribute];
			}
		}
		
		return $object;
	}
	
	public function get_attributes(){
		global $db;
		$attributes = array();
		$called_class = get_called_class();
		foreach($called_class::$db_fields as $field){
			$attributes[$field] = $db->escape_string($this->$field);
		}
		return $attributes;
	}
	
	public function create(){
		global $db;
		// INSERT INTO table_name (column1,column2,column3,...)
		// VALUES (value1,value2,value3,...);
		
		$attributes = self::get_attributes();
	
		$sql = "INSERT INTO ". static::$table_name." (";
		$sql.= implode(",", array_keys($attributes));
		$sql.= ") VALUES ('";
		$sql.= implode("', '", array_values($attributes));
		$sql.="')";
		
		$result = $db->query($sql);	
	
		if(!$db->confirm_query($result)){
			return false;
		}
		
		return $db->insert_id;
	}
	
	public function update(){
		global $db;
		
		// UPDATE table_name
		// SET column1=value, column2=value2,...
		// WHERE some_column=some_value
		
		$attributes = self::get_attributes();
		$keys = array_keys($attributes);
		$values = array_values($attributes);
		
		$sql = "UPDATE ". static::$table_name . " ";
		$sql.= "SET ";
		for($i = 0; $i < count($attributes); $i++){
			$sql.= $keys[$i]. "='" . $values[$i] . "'";
			// Add comma after every attribute except for the last one.
			if(!($i == count($attributes)-1)){
				$sql.=", ";
			}
		}
		$sql.= " WHERE id=".$this->id;
		
		$result = $db->query($sql);	
	
		if(!$db->confirm_query($result)){
			return false;
		}
	}
	
	public function delete(){
		global $db;
		
		// DELETE FROM table_name
		// WHERE some_column=some_value;
		
		$sql = "DELETE FROM ".static::$table_name;
		$sql.= " WHERE id=".$this->id;
		
		$result = $db->query($sql);
		
		if(!$db->confirm_query($result)){
			return false;
		}
	}
}

?>
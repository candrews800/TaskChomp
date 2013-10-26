<?php require_once("includes/initialize.php");

if(!$session->is_logged_in()){
	redirect_to("index.php");
	die();
}
else{
	
	// Get Method
	if(empty($_GET['method'])){
		die("No method selected.");
	}
	else{
		switch($_GET['method']){
			case "create":
				$method = "create";
				break;
			case "update":
				$method = "update";
				break;
			case "delete":
				$method = "delete";
				break;
			case "move":
				$method = "move";
				break;
			default:
				die("No valid method selected.");
		}
	}
	
	// Get Class
	if(empty($_GET['class'])){
		die("No method selected.");
	}
	else{
		$cl_name = strtolower($_GET['class']);
		switch($cl_name){
			case "category":
				$class = "Category";
				break;
			case "tasklist":
				$class = "TaskList";
				break;
			case "item":
				$class = "Item";
				break;
			case "subitem":
				$class = "SubItem";
				break;
			default:
				die("No valid class selected.");
				break;
		}
	}
	
	// Get Class ID
	if(!empty($_GET['class_id'])){
		$class_id = $_GET['class_id'];
	}
	
	if(!empty($_POST['class_id'])){
		$class_id = $_POST['class_id'];
	}
	
	if(!empty($_GET['var_attr'])){
		$var_attr = $_GET['var_attr'];
	}
	
	if(!empty($_GET['var_attr']) && isset($_POST['var_val'])){
		$var_attr = $_GET['var_attr'];
		$var_val = $_POST['var_val'];
	}
	
	if($method == "delete" && !empty($class_id)){
		$initialized = $class::find_by_id($class_id);
		
		
		
		
		$initialized->delete();
		
		if($class=="Item" && $initialized->status == 1){
			$rel_list = TaskList::find_by_id($initialized->list_id);
			$rel_category = Category::find_by_id($rel_list->category_id);
			
			$rel_list->update_finished_amt(0);
			$rel_category->update_finished_amt(0);
		}
		
		else if($class=="TaskList"){
			$rel_category = Category::find_by_id($initialized->category_id);
			
			$rel_category->delete_list_unfinished($initialized->id);
		}
		
		if($class=="Category"){			
			$last_url = $_SERVER['HTTP_REFERER'];
			$parts = parse_url($last_url);
			redirect_to($parts['path']);
			die();
		}
		
		redirect_to($_SERVER['HTTP_REFERER']);
	}
	
	if($method == "update" && $class == "SubItem" && $var_attr == "status"){
		$subitem = SubItem::find_by_id($class_id);
		
		if($subitem->user_id == $session->user_id){
			$subitem->toggle_status();
			
			echo $subitem->status;
		}
	}
	
	if($method == "update" && $class == "Item" && $var_attr == "status"){
		$item = Item::find_by_id($class_id);
		$rel_list = TaskList::find_by_id($item->list_id);
		$rel_category = Category::find_by_id($rel_list->category_id);
		
		if($item->user_id == $session->user_id){
			$item->toggle_status();
			
			$rel_list->update_finished_amt($item->status);
			$rel_category->update_finished_amt($item->status);
			
			$list_status = TaskList::get_status($item->list_id);
						
			echo $list_status;
		}
	}
	
	if($method == "update" && $class == "TaskList" && $var_attr == "edit"){
		$item = TaskList::find_by_id($class_id);
		
		if($item->user_id == $session->user_id){
			$item->toggle_edit();
		}
		
		redirect_to($_SERVER['HTTP_REFERER']);
	}
	
	if($method == "update" && !empty($var_attr) && isset($var_val) && !empty($class_id)){
		// $class_id is actually var_attr-Class-ID, eg. date-Item-12, title-SubItem-20030, title-TaskList-2, date-Category-40
		// Need to grab ID from the string before finding it within database
		
		$class_id = substr($class_id, strlen($class) + strlen($var_attr) + 2);

		$initialized = $class::find_by_id($class_id);
		$initialized->$var_attr = $var_val;
		$initialized->update();
		echo $initialized->$var_attr;
	}
	
	if($method == "create" && !empty($_POST['title'])){
		if(empty($_GET['parent_id']) && $class == "Category"){
			$initialized = new $class();
			$initialized->title = $_POST['title'];
			$initialized->user_id = $session->user_id;
			$cat_id = $initialized->create();
			redirect_to("home.php?category_id=".$cat_id);
			die();
		}
		else if(!empty($_GET['parent_id'])){
			$initialized = new $class();
			if($class == "Item"){
				$initialized->list_id = $_GET['parent_id'];
				$initialized->status = 1;
				$initialized->order_id = get_last_order_id("Item", "list_id", $initialized->list_id);
				$rel_list = TaskList::find_by_id($initialized->list_id);
				$rel_category = Category::find_by_id($rel_list->category_id);
			}
			else if($class == "TaskList"){
				$initialized->category_id = $_GET['parent_id'];
				$initialized->status = 2;
				$initialized->edit = 1;
				$add_url = "home.php?category_id={$initialized->category_id}&list_id=";
			}
			else if($class == "SubItem"){
				$initialized->item_id = $_GET['parent_id'];
				$initialized->status = 1;
				$initialized->order_id = get_last_order_id("SubItem", "item_id", $initialized->item_id);
			}

			$initialized->title = $_POST['title'];
			$initialized->user_id = $session->user_id;
			

			$insert_id = $initialized->create();
			
			if($class == "Item"){
				$rel_list->update_finished_amt(1);
				$rel_category->update_finished_amt(1);
			}
		}
		
		if(isset($add_url)){
			redirect_to($add_url.$insert_id);
			die();
		}
		redirect_to($_SERVER['HTTP_REFERER']);
		
	}
	
	if($method == "move" && !empty($class) && !empty($class_id) && isset($_GET['position'])){
		$initialized = $class::find_by_id($class_id);
		$position = $_GET['position'];
		
		if($position != $initialized->order_id){
			echo $initialized->move($position);
		}
	}
}

?>
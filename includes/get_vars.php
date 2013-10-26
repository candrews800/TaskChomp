<?php

// This initializes the variables for use later:
// 		$categories, $selected_category, $lists, $selected_list, $items and sets all subitems within $items->subitems


// Redirect Users Not Logged In
if(!$session->is_logged_in()){
	$session->set_msg("Please Login.");
	redirect_to("index.php");	
}

else{
	
	$categories = Category::find_all("user_id", $user->id);
	// Get Lists From Category
	
	// If Category is known
	if(!empty($categories)){
		if(!empty($_GET['category_id'])){
			$category_id = $_GET['category_id'];
		}
		
		// If No Category Selected, Grab First
		else{
			$category_id = $categories[0]->id;
		}
		
		// If You have a valid category id belonging to the user, grab all lists
		if($selected_category = validate("Category", $category_id)){
			$ulists = TaskList::find_all("user_id", $selected_category->user_id, "category_id", $selected_category->id);
			// Sort Lists Based on Status, then combine
			$status0 = array();
			$status1 = array();
			$status2 = array();
			foreach($ulists as $list){
				switch($list->status){
					case 0:
						$status0[] = $list;
						break;
					case 1:
						$status1[] = $list;
						break;
					case 2:
						$status2[] = $list;
						break;
				}
			}
			$lists = array_merge($status1, $status2, $status0);
		}
		else{
			redirect_to("home.php");
		}
	}

	// Get Items From List if we have a lists to grab from
	if(!empty($lists)){
		
		// If List Id is known
		if(!empty($_GET['list_id'])){
			$list_id = $_GET['list_id'];
		}
		
		// If No List is Selected, Grab From First List 
		else{
			if(!empty($lists)){
				$list_id = $lists[0]->id;
			}
		}
		
		if($selected_list = validate("TaskList", $list_id)){
			$items = Item::get_list_items($selected_list->user_id, $selected_list->id);
		}
		else{
			redirect_to("home.php?category_id=".$category_id);
		}
	}
	
	// Get Sub Items From Item List
	if(!empty($items)){
		foreach($items as $item){
			$item->subitems = SubItem::subitems_from_item($item->user_id, $item->id);
		}
	}
	
}

?>
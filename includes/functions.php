<?php

function redirect_to($url){
	header('Location: '.$url);
}

function get_last_order_id($table, $parent_table_name, $parent_table){
	global $db;
	
	$sql = "SELECT *
			FROM {$table}
			WHERE {$parent_table_name}={$parent_table}
			ORDER BY order_id DESC
			LIMIT 1";
			
	$result_set = $db->query($sql);
	$result = $result_set->fetch_array();
	
	if(!$result){
		return 0;
	}
	
	return $result['order_id']+1;
}

function validate($class_name, $class_id){
	// Validates that a Given an Initialized Class belongs to a user
	if($selected_class = $class_name::find_by_id($class_id)){
		if($selected_class->user_id == $_SESSION['user_id']){
			return $selected_class;
		}
	}
	
	return false;
}

function icon($icon_name){
	echo "<i class=\"glyphicon glyphicon-{$icon_name}\"></i>";
}

function date_picker($class){
	/*
?>
	
	<span><?php echo $class->date; ?></span>
	
<?php
	 
	 */
}

function trash($class){
?>

<a class="btn trash" href="update.php?method=delete&class=<?php echo get_class($class); ?>&class_id=<?php echo $class->id; ?>" onclick="return confirm('Delete <?php echo $class->title; ?>\?')"><?php icon("trash"); ?></a>

<?php
}

function modal_new_list($category){
?>
	<div class="modal fade" id="newlist<?php echo $category->id; ?>" style="margin-top: 100px">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	          <h4 class="modal-title">Add New List to <?php echo $category->title; ?></h4>
	        </div>
	        <div class="modal-body modal-new-list clearfix">
	         	<form class="form-inline" action="update.php?method=create&class=tasklist&parent_id=<?php echo $category->id; ?>" method="post">
					<input type="text" name="title" class="form-control pull-left" placeholder="New List">
				
					<button type="submit" class="btn btn-success pull-right">Add List</button>
			  	</form>
	        </div>
	      </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	  </div><!-- /.modal -->
<?php
}

function modal_new_category(){
?>
<!-- Modal -->
  <div class="modal fade" id="newCategory" style="margin-top: 100px; ">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add A New Category</h4>
        </div>
        <div class="modal-body">
         	<form class="form-inline clearfix" action="update.php?method=create&class=category" method="post">
				<input type="text" name="title" class="form-control new-category-form pull-left" placeholder="Category Name">
			
				<button type="submit" class="btn btn-success pull-right">Create Category</button>
		  	</form>
        </div>
 
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  

<?php
}

function modal_edit_category(){
	global $categories;
?>
 <div class="modal fade" id="categorySettings" style="margin-top: 100px;">
    <div class="modal-dialog">
      <div class="modal-content">
      	<div class="modal-header">
          <h4 class="modal-title">Edit Categories</h4>
        </div>
      	<div class="modal-body">
      		<ul id="category-sortable">
	       	<?php if(!empty($categories)){ foreach($categories as $category){ ?> 
	       		<li>
	       			<?php trash($category); ?>
	       			<span id="title-category-<?php echo $category->id; ?>" class="category-edit"><?php echo $category->title; ?></span> 
	       		</li>
	 		<?php }} ?>
 			</ul>
 		</div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php
}

?>
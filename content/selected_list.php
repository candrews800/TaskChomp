<?php
	if($selected_list->status == 0){
		// Complete
		$labelcss = "label-success";
		$labeltext = "Complete";
	}
	else if($selected_list->status == 1){
		// In Progress
		$labelcss = "label-warning";
		$labeltext = "In Progress";
	}
	else{
		// Not Started
		$labelcss = "label-default";
		$labeltext = "Not Started";
	}
	
	if($selected_list->edit){
		$editcss = "edit";
	}
	else{
		$editcss = "lock";
	}
	
?>

<div class="list-header clearfix">
	<h1 id="title-tasklist-<?php echo $selected_list->id; ?>" class="tasklist-title tasklist-edit <?php if($selected_list->status == 0){ echo"complete";} ?>"><?php echo $selected_list->title; ?></h1>
	<span id="date-tasklist-<?php echo $selected_list->id; ?>" class="tasklist-date"><?php date_picker($selected_list); ?></span>
	<span id="label-tasklist-<?php echo $selected_list->id; ?>" class="label label-default <?php echo $labelcss; ?>"><?php echo $labeltext; ?></span>
	
	<!-- List Settings -->
	<?php if(!$selected_list->edit){ ?>
		<a class="btn btn-default dropdown-toggle options-locked pull-right" href="update.php?method=update&class=tasklist&class_id=<?php echo $selected_list->id; ?>&var_attr=edit"><?php icon("lock"); ?></a>
	<?php } else{ ?>
	<div class="btn-group pull-right">
	  	<button type="button" class="btn dropdown-toggle options" data-toggle="dropdown">
	    	<?php icon("wrench"); ?>
	  	</button>
	  	<ul class="dropdown-menu">
	    	<li><a href="update.php?method=delete&class=tasklist&class_id=<?php echo $selected_list->id; ?>" onclick="return confirm('Delete <?php echo $selected_list->title; ?>\?')">Delete List <?php icon("remove"); ?></a></li>
	  	</ul>
	</div>
	<?php } ?>
</div>
<ul id="item-sortable" class="list-body">
<?php 
	if(!empty($items)){ 
	$item_num = 1; 
	foreach($items as $item){ 
?>	
	<li id="item-<?php echo $item->id; ?>" class="item clearfix <?php if($items[0] == $item){echo "item-top"; }?> <?php if($item->status == 0){ echo"complete";} ?>">
		<div class="grab-texture"></div>
		<span id="num-item-<?php echo $item->id; ?>" class="item-num text-muted"><?php echo $item_num; ?></span>
		<span id="title-item-<?php echo $item->id; ?>" class="item-title item-edit <?php if($item->status == 0){ echo"complete";} ?>"><?php echo $item->title; ?></span>
		<span id="date-item-<?php echo $item->id; ?>" class="item-date"><?php date_picker($item); ?></span>
		<span class="item-trash pull-right <?php echo $editcss; ?>"><?php trash($item); ?></span>
		<span id="actions-item-<?php echo $item->id; ?>" class="item-actions"><?php item_status_button($item); ?></span>
		<p id="see-more-<?php echo $item->id; ?>" class="see-more text-muted">[+] show more</p>
		
		<ul id="subitem-<?php echo $item->id; ?>" class="subitems subitem-sortable">
			
			<?php 
				if(!empty($item->subitems)){
				$letter = 'a'; 
				foreach($item->subitems as $subitem){  
			?>
			<li id="subitem-<?php echo $subitem->id; ?>" class="subitem clearfix">
				<span id="num-subitem-<?php echo $subitem->id; ?>" class="subitem-num text-muted"><?php echo $letter; $letter++; ?></span>
				<span id="title-subitem-<?php echo $subitem->id; ?>" class="subitem-title subitem-edit <?php if($subitem->status == 0){ echo"complete";} ?>"><?php echo $subitem->title; ?></span>
				<span class="subitem-trash pull-right <?php echo $editcss; ?>"><?php trash($subitem); ?></span>
				<span id="actions-subitem-<?php echo $subitem->id; ?>" class="subitem-actions"><?php subitem_status_button($subitem); ?></span>
			</li>
			<?php 
				} // end foreach(subitems)
				} // end if(empty(subitems))
			?>
			<li class="subitem clearfix subitem-form <?php echo $editcss; ?>">
				<form class="form-inline" action="update.php?method=create&class=subitem&parent_id=<?php echo $item->id; ?>" method="post">
					<span class="subitem-num subitem-num-edit text-muted"><?php icon("plus"); ?></span>
				  	<input type="text" name="title" class="form-control subitem-new" placeholder="add sub task...">
				</form>
			</li>
		</ul>
	</li>
<?php 
	$item_num++;
	} 	//end foreach(items)
 	} 	// end if(empty(items))
?>
</ul>

<div class="list-footer <?php echo $editcss; ?> not-item-sortable <?php if(empty($items)){echo "no-items";} ?>" >
	<form class="form-inline" action="update.php?method=create&class=item&parent_id=<?php echo $selected_list->id; ?>" method="post">
		<span class="item-num item-num-edit text-muted"><?php icon("plus"); ?></span>
	  	<input type="text" name="title" class="form-control item-new" placeholder="add task..." maxlength="52">
	</form>
</div>


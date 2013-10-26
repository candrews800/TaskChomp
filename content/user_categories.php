<aside>
	
<div class="categories-header pull-left clearfix">
	<a id="category-add" data-toggle="modal" href="#newCategory" class="pull-right">Create <span><?php icon("plus-sign"); ?></span></a>
	<a id="category-settings" data-toggle="modal" href="#categorySettings" class="pull-right">Settings <span><?php icon("cog"); ?></span></a>
	<p class="categories-user pull-right"><?php echo $user->username; ?>'s Categories: </p> 
</div>

<div class="user-categories-wrap">
<!-- List Categories -->
<?php if(!empty($categories)){ foreach($categories as $category){ ?>
<div class="category clearfix <?php if($categories[0] === $category){echo "category-top";} ?>">
	
	<!-- Category Name/Block -->
	<a href="home.php?category_id=<?php echo $category->id; ?>">
	<div class="category-header clearfix <?php if(!empty($selected_category)){ if($selected_category->id == $category->id){echo "active";}} ?>">
	
		<h3 class=""><?php echo $category->title; ?> 
			<span class="badge"><?php if($category->unfinished > 0){echo $category->unfinished; } ?></span>
		</h3>
	
	<?php if(!empty($selected_category)){ if($selected_category->id == $category->id){ ?>
	
	<?php }} ?>
	</div></a>
	<!-- Display all the lists for the selected category -->
	<?php if(!empty($category_id)){ if($category->id == $category_id){ ?>
	<div class="list-content ">
		<ul class="content nano">
			<div class="content">
			<?php if(!empty($lists)){ foreach($lists as $list){  
				
				if($list->status == 0){
					$list_css = "complete";
					$status_text = "Complete";
					$status_css = "text-success";
				}
				else if($list->status == 1){
					$list_css = "";
					$status_text = "In Progress";
					$status_css = "text-warning";
				}
				else{
					$list_css = "";
					$status_text = "Not Started";
					$status_css = "text-muted";
				}
				?>
			<!-- Cycle Through Selected Lists -->
			<a href="home.php?category_id=<?php echo $category->id; ?>&list_id=<?php echo $list->id; ?>">
				<li class="<?php echo $list_css; if(!empty($selected_list)){ if($selected_list->id == $list->id){echo " active";}} ?>">
					<span class="<?php echo $list_css; if(!empty($selected_list)){ if($selected_list->id == $list->id){echo " selected_list-title";}} ?>"><?php echo $list->title; ?></span>
					<span class="badge"><?php if($list->unfinished > 0) {echo $list->unfinished; } ?></span>
					<?php echo "<span class=\"category-list-status {$status_css}\">{$status_text}</span>"; ?>
					<?php date_picker($selected_list); ?>
				</li>
			</a>
			<hr />
			<?php }} ?>			
			</div>								
		</ul>
		<p class="new-list">
			<a id="list-add" class="btn btn-block btn-info btn-mini" data-toggle="modal" href="#newlist<?php echo $category->id; ?>" ><span><strong><?php icon("plus"); ?></span>Create List</strong></a>
		</p>		
	</div>
	
	<?php }} // end $lists foreach and test for list ?>
</div>
<?php }} // end $categories foreach ?>
</div> <!-- category wrap -->

<?php if(!empty($selected_category)){modal_new_list($selected_category);} ?>
<?php modal_new_category(); ?>
<?php modal_edit_category(); ?>
</aside>

